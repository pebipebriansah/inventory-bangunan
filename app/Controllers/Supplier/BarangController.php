<?php

namespace App\Controllers\Supplier;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangSupplierModel;

class BarangController extends BaseController
{
    protected $barangSupplierModel;
    public function __construct() {
        $this->barangSupplierModel = new BarangSupplierModel();
    }
    public function index()
    {
        $lastID = $this->barangSupplierModel->getLastID();
        if ($lastID == null) {
            $incrementId = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            // Ambil bagian numerik setelah tanda "-"
            $sliceId = substr($lastID, strpos($lastID, '-') + 1); // Mengambil bagian setelah "-"
            $incrementId = intval($sliceId) + 1; // Konversi ke integer dan tambahkan 1
        }
        $idBarang = 'BRGS-' . str_pad($incrementId, 3, '0', STR_PAD_LEFT);
        $data = [
            'title' => 'Barang Supplier',
            'data_barang' => $this->barangSupplierModel->where('id_supplier', session()->get('id_supplier'))->findAll(),
            'lastId' => $idBarang
        ];
        return view ('pages/supplier/data-barang',$data);
    }
    public function save(){
        $id_supplier = session()->get('id_supplier');
        $data = $this->request->getVar();
        $data['id_supplier'] = $id_supplier;
    //    insert data
    $this->barangSupplierModel->insert($data);
    return redirect()->to('/supplier/data-barang')->with('success', 'Data Barang berhasil disimpan');
    }
    public function delete($id){
        $this->barangSupplierModel->delete($id);
        return redirect()->to('/supplier/data-barang')->with('success', 'Data Barang berhasil dihapus');
    }
    public function update($id){
        $data = $this->request->getVar();
        $this->barangSupplierModel->update($id, $data);
        return redirect()->to('/supplier/data-barang')->with('success', 'Data Barang berhasil diupdate');
    }
    public function getBarangSupplier($id){
        $barang = $this->barangSupplierModel->find($id);
        return $this->response->setJSON($barang);
    }
}