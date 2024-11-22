<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PenjualanModel;
use CodeIgniter\HTTP\ResponseInterface;

class PenjualanController extends BaseController
{
    protected $penjualanModel;
    protected $barangModel;
    protected $barangKeluar;
    public function __construct() {
        $this->penjualanModel = new PenjualanModel();
        $this->barangModel = new BarangModel();
        $this->barangKeluar = new \App\Models\BarangKeluarModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Data Penjualan',
            'penjualan' => $this->penjualanModel->join('tbl_barang', 'tbl_barang.id_barang = tbl_penjualan.id_barang')->findAll(),
            'barang' => $this->barangModel->findAll(),
        ];
        return view('pages/admin/penjualan', $data);
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
        $this->penjualanModel->insert($dataPenjualan);
        session()->setFlashdata('success', 'Data Penjualan berhasil disimpan');
        return redirect()->to('/admin/penjualan');
    }
}
