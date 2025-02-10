<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class BarangMasukController extends BaseController
{
    protected $barangMasukModel;
    protected $barangKeluarModel;
    protected $pageUtama;
    public function __construct() {
        $this->barangMasukModel = new BarangMasukModel();
        $this->barangKeluarModel = new \App\Models\BarangKeluarModel();
        $this->pageUtama = 'pages/admin/barang-masuk/data-barang-masuk';
    }
    public function index()
    {
        $data = [
            'barang_masuk' => $this->barangMasukModel->getBarangMasukFIFO(),
            'title' => 'Barang Masuk'
        ];
        
        return view($this->pageUtama, $data);
    }
    public function getBarangMasuk(){
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $data = $this->barangMasukModel->getBarangMasukQuery();
        if ($startDate && $endDate) {
            $data->where('tbl_barang_masuk.tanggal_masuk >=', $startDate)
                ->where('tbl_barang_masuk.tanggal_masuk <=', $endDate);
        }
        return DataTable::of($data)
            ->addNumbering()
            ->add('aksi', function ($row) {
                return '<a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#keluarkanModal" data-user-id="' . $row->id_barang_masuk. '">Keluarkan</a>';
            })
            ->toJson();
    }
    public function keluar($id) {
        $jumlah = $this->request->getPost('jumlah');
        
        // Validasi jumlah harus angka dan lebih dari 0
        if (!$jumlah || !is_numeric($jumlah) || $jumlah <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Jumlah harus berupa angka yang valid dan lebih dari 0'
            ]);
        }
    
        $barangMasukStok = $this->barangMasukModel->find($id);
    
        // Cek jika data ditemukan
        if (!$barangMasukStok) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Barang tidak ditemukan'
            ]);
        }
    
        // Cek stok tidak boleh kurang dari jumlah yang diminta
        if ($barangMasukStok['stok'] < $jumlah) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Stok tidak mencukupi!'
            ]);
        }
    
        // Hitung stok akhir
        $stokAkhir = $barangMasukStok['stok'] - $jumlah;
    
        // Generate ID barang keluar
        $lastIDKeluar = $this->barangKeluarModel->getLastID();
        $incrementIdKeluar = ($lastIDKeluar === null) ? 1 : intval(substr($lastIDKeluar, 5)) + 1;
        $idKeluar = 'BRGK-' . str_pad($incrementIdKeluar, 3, '0', STR_PAD_LEFT);
    
        // Data untuk barang keluar
        $dataKeluar = [
            'id_barang_keluar' => $idKeluar,
            'id_barang_masuk' => $barangMasukStok['id_barang_masuk'],
            'jumlah' => $jumlah,
            'tanggal_keluar' => date('Y-m-d')
        ];
        $this->barangKeluarModel->insert($dataKeluar);
        // Update stok barang masuk
        $this->barangMasukModel->update($id, ['stok' => $stokAkhir]);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data Barang berhasil dikeluarkan!'
        ]);
    }    
}