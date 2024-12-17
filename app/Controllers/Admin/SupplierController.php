<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class SupplierController extends BaseController
{
    protected $supplierModel;
    protected $pageUtama;
    protected $uriUtama;
    public function __construct() {
        $this->supplierModel = new SupplierModel();
        $this->pageUtama = 'pages/admin/supplier/data-supplier';
        $this->uriUtama = 'admin/data-supplier';
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
            'last_id' => $idSupplier,
        ];
        return view ($this->pageUtama,$data);
    }
    public function getSupplier(){
        $data = $this->supplierModel->getSupplierQuery();
        return DataTable::of($data)
        ->addNumbering()
        ->add('aksi', function($row){
            return '<a href="' . site_url('admin/data-supplier/edit/' . $row->id_supplier) . '" class="btn btn-primary">Edit</a>
                   <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-supplier-id="'. $row->id_supplier. '">Hapus</a>';
        })->toJson();
    }
    public function save() {
        $idSupplier = $this->request->getPost('id_supplier');
        $namaSupplier = $this->request->getPost('nama_supplier');
        $alamat = $this->request->getPost('alamat');
        $kategori = $this->request->getPost('kategori');
        // Validasi data
        $data = [
            'id_supplier' => $idSupplier,
            'nama_supplier' => $namaSupplier,
            'alamat' => $alamat,
            'kategori' => $kategori
        ];
        // Menyimpan data
        if ($this->supplierModel->insert($data) !== false) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Supplier berhasil disimpan'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Supplier gagal disimpan'
            ]);
        }
    }
    public function edit($id) {
        $supplier = $this->supplierModel->find($id);
        if (!$supplier) {
            return redirect()->to('admin/data-supplier')->with('error', 'User tidak ditemukan');
        }
        return view('pages/admin/supplier/edit-supplier', ['supplier' => $supplier]);
    }
    public function delete($id)
    {
        if ($this->supplierModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Supplier berhasil dihapus!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data Supplier.'
            ]);
        }
    }
    public function update()
{
    $SupplierId = $this->request->getPost('id_supplier');
    $namaSupplier = $this->request->getPost('nama_supplier');
    $alamat = $this->request->getPost('alamat');
    $kategori = $this->request->getPost('kategori');

    // Cek apakah pengguna ada
    $supplier = $this->supplierModel->find($SupplierId);
    if ($supplier) {
        // Update data pengguna
        $this->supplierModel->update($SupplierId, [
            'nama_supplier' => $namaSupplier,
            'alamat' => $alamat,
            'kategori' => $kategori
        ]);
        return redirect()->to('admin/data-supplier')->with('success', 'Data Supplier berhasil diperbarui');
    } else {
        return redirect()->to('admin/data-supplier')->with('error', 'Data Supplier tidak ditemukan');
    }
}
}