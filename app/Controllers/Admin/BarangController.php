<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class BarangController extends BaseController
{
    protected $barangModel;
    protected $supplierModel;

    public function __construct() {
        $this->barangModel = new BarangModel();
        $this->supplierModel = new SupplierModel();

    }
    public function index()
    {
        $lastID = $this->barangModel->getLastID();
        if ($lastID == null) {
            $incrementId = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik dari ID
            $sliceId = substr($lastID, 4); // Mengambil karakter setelah "SUP-"
            
            // Pastikan bagian numerik diproses dengan benar
            $incrementId = intval($sliceId) + 1; // Konversi ke integer dan tambahkan 1
        }
        $id_barang = 'BRG-'.str_pad($incrementId, 3, '0', STR_PAD_LEFT);
        $data = [
            'title' => 'Data Barang',
            'data_barang' => $this->barangModel->join('tbl_supplier','tbl_supplier.id_supplier = tbl_barang.id_supplier')->findAll(),
            'data_supplier' => $this->supplierModel->findAll(),
            'lastId' => $id_barang,
        ];
        return view('pages/admin/data-barang',$data);
    }
    public function save(){
        $data = $this->request->getPost();
        if($this->barangModel->insert($data)==true){
        session()->setFlashdata('success', 'Data Barang berhasil disimpan');
        return redirect()->to('/admin/data-barang');
        }else{
            session()->setFlashdata('error', 'Data Barang gagal disimpan');
            $error = $this->barangModel->errors(); // Mengambil kesalahan jika ada
            log_message('error', 'Insert failed: ' . json_encode($error)); // Log kesalahan ke file log
            return redirect()->to('/admin/data-barang');
        }
    }
    public function delete($id){
        $this->barangModel->delete($id);
        session()->setFlashdata('success', 'Data Barang berhasil dihapus');
        return redirect()->to('/admin/data-barang');
    }
}