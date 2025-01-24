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
        $this->barangMasuk = new \App\Models\BarangMasukModel();
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
    public function save()
    {
        $data = $this->request->getPost();

        // Generate Penjualan ID
        $lastID = $this->penjualanModel->getLastID();
        $incrementId = ($lastID == null) ? 1 : intval(substr($lastID, 4)) + 1;
        $idPenjualan = 'PJN-' . str_pad($incrementId, 3, '0', STR_PAD_LEFT);

        // Generate Barang Keluar ID
        $lastIDKeluar = $this->barangKeluar->getLastID();
        $incrementIdKeluar = ($lastIDKeluar == null) ? 1 : intval(substr($lastIDKeluar, 5)) + 1;
        $idKeluar = 'BRGK-' . str_pad($incrementIdKeluar, 3, '0', STR_PAD_LEFT);

        // Jumlah barang yang akan dijual
        $qtyKeluar = $data['qty'];
        $idBarang = $data['id_barang'];

        // Ambil stok barang masuk berdasarkan FIFO
        $stokBarangMasuk = $this->barangMasuk
            ->where('id_barang', $idBarang)
            ->where('stok >', 0)
            ->orderBy('tanggal_masuk', 'ASC')
            ->findAll();

        $totalStokTersedia = array_sum(array_column($stokBarangMasuk, 'stok'));
        if ($qtyKeluar > $totalStokTersedia) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Stok tidak mencukupi untuk penjualan.'
            ]);
        }

        foreach ($stokBarangMasuk as $batch) {
            if ($qtyKeluar <= 0) break;

            if ($batch['stok'] >= $qtyKeluar) {
                $this->barangMasuk->update($batch['id_barang_masuk'], [
                    'stok' => $batch['stok'] - $qtyKeluar
                ]);
                $qtyKeluar = 0;
            } else {
                $qtyKeluar -= $batch['stok'];
                $this->barangMasuk->update($batch['id_barang_masuk'], ['stok' => 0]);
            }
        }

        // Simpan data barang keluar
        $dataBarangKeluar = [
            'id_barang_keluar' => $idKeluar,
            'id_penjualan' => $idPenjualan,
            'tanggal_keluar' => date('Y-m-d'),
        ];
        $this->barangKeluar->insert($dataBarangKeluar);

        // Simpan data penjualan
        $dataPenjualan = [
            'id_penjualan' => $idPenjualan,
            'id_barang' => $idBarang,
            'qty' => $data['qty'],
            'total' => $data['total'],
        ];

        if ($this->penjualanModel->insert($dataPenjualan) !== false) {
            // Buat pesan FIFO
            $fifoMessage = "Barang keluar berhasil menggunakan FIFO dengan batch:\n";
            foreach ($stokBarangMasuk as $batch) {
                if ($batch['stok'] > 0) {
                    $fifoMessage .= "- Batch ID: {$batch['id_barang_masuk']}, Tanggal Pemesanan: {$batch['tanggal_masuk']}, Sisa Stok: {$batch['stok']}.\n";
                }
            }
        
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Penjualan berhasil disimpan. ' . $fifoMessage
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