<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class SupplierController extends BaseController
{
    protected $supplierModel;
    public function __construct() {
        $this->supplierModel = new SupplierModel();
    }
    public function index()
    {
        $lastID = $this->supplierModel->getLastID();
        if ($lastID == null) {
            $incrementId = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik dari ID
            $sliceId = substr($lastID, 4); // Mengambil karakter setelah "SUP-"
            
            // Pastikan bagian numerik diproses dengan benar
            $incrementId = intval($sliceId) + 1; // Konversi ke integer dan tambahkan 1
        }
        $idSupplier = 'SUP-'.str_pad($incrementId, 3, '0', STR_PAD_LEFT);
        $data = [
            'title' => 'Data Supplier',
            'data_supplier' => $this->supplierModel->findAll(),
            'last_id' => $idSupplier,
        ];
        return view ('pages/admin/data-supplier',$data);
    }
    public function save(){
        $data = $this->request->getPost();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->supplierModel->insert($data);
        session()->setFlashdata('success', 'Data Supplier berhasil disimpan');
        return redirect()->to('/admin/data-supplier');
    }
    public function delete($id){
        if($this->supplierModel->delete($id)==true){
            session()->setFlashdata('success', 'Data Supplier berhasil dihapus');
            return redirect()->to('/admin/data-supplier');
        }else{
            session()->setFlashdata('error', 'Data Supplier gagal dihapus');
            return redirect()->to('/admin/data-supplier');
        }
    }
    public function update($id){
        $data = $this->request->getPost();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if($this->supplierModel->update($id, $data)==true){
            session()->setFlashdata('success', 'Data Supplier berhasil diupdate');
            return redirect()->to('/admin/data-supplier');
        }else{
            session()->setFlashdata('error', 'Data Supplier gagal diupdate');
            return redirect()->to('/admin/data-supplier');
        }
    }   
}