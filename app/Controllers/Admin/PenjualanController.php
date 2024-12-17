<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PenjualanModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class PenjualanController extends BaseController
{
    protected $penjualanModel;
    protected $barangModel;
    protected $barangKeluar;
    protected $pageUtama;
    protected $uriUtama;
    public function __construct() {
        $this->penjualanModel = new PenjualanModel();
        $this->barangModel = new BarangModel();
        $this->barangKeluar = new \App\Models\BarangKeluarModel();
        $this->pageUtama = 'pages/admin/penjualan/penjualan';
        $this->uriUtama = 'admin/data-penjualan';
    }
    public function index()
    {
        $data = [
            'title' => 'Data Penjualan',
            'barang' => $this->barangModel->findAll(),
        ];
        return view($this->pageUtama, $data);
    }
    public function getPenjualan(){
        $penjualan = $this->penjualanModel->getPenjualanQuery();
        return DataTable::of($penjualan)
        ->addNumbering()
        ->add('aksi', function($row){
            return '<a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-penjualan-id="'. $row->id_penjualan. '">Hapus</a>';
        })
        ->toJson();
    }
    public function getBarang($id){
        $barang = $this->barangModel->getBarangById($id);
        return $this->response->setJSON($barang);
    }
    public function save(){
        //Generate Penjualan ID
        $lastID = $this->penjualanModel->getLastID();
        if ($lastID == null) {
            $incrementId = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik dari ID
            $sliceId = substr($lastID, 4); // Mengambil karakter setelah "SUP-"
            
            // Pastikan bagian numerik diproses dengan benar
            $incrementId = intval($sliceId) + 1; // Konversi ke integer dan tambahkan 1
        }
        $idPenjualan = 'PJN-'.str_pad($incrementId, 3, '0', STR_PAD_LEFT);
        //Generate Barang Keluar ID
        $lastIDKeluar = $this->barangKeluar->getLastID();
        if ($lastIDKeluar == null) {
            $incrementIdKeluar = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik dari ID
            $sliceIdKeluar = substr($lastIDKeluar, 5); // Mengambil karakter setelah "SUP-"
            
            // Pastikan bagian numerik diproses dengan benar
            $incrementIdKeluar = intval($sliceIdKeluar) + 1; // Konversi ke integer dan tambahkan 1
        }
        $idKeluar = 'BRGK-'.str_pad($incrementIdKeluar, 3, '0', STR_PAD_LEFT);
        $data = $this->request->getPost();
        $dataBarang = $this->barangModel->find($data['id_barang']);
        $this->barangModel->update($data['id_barang'], ['stok' => $dataBarang['stok'] - $data['qty']]);
        $dataBarangKeluar = [
            'id_barang_keluar' => $idKeluar,
            'id_penjualan' => $idPenjualan,
            'tanggal_keluar' => date('Y-m-d'),
        ];
        $this->barangKeluar->insert($dataBarangKeluar);
        $data['id_penjualan'] = $idPenjualan;
        $dataPenjualan = [
            'id_penjualan' => $idPenjualan,
            'id_barang' => $data['id_barang'],
            'qty' => $data['qty'],
            'total' => $data['total']
        ];
        if ($this->penjualanModel->insert($dataPenjualan) !== false) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Penjualan berhasil disimpan'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Penjualan gagal disimpan'
            ]);
        }
    }
    public function getPenjualanTerbanyak()
    {
        $data = $this->penjualanModel->getPenjualanTerbanyak();
        return $this->response->setJSON($data);
    }
    public function delete($id)
    {
        if ($this->penjualanModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Penjualan berhasil dihapus!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data Penjualan.'
            ]);
        }
    }
}