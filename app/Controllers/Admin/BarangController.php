<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class BarangController extends BaseController
{
    protected $barangModel;
    protected $supplierModel;
    protected $pageUtama;
    protected $uriUtama;

    public function __construct() {
        $this->barangModel = new BarangModel();
        $this->supplierModel = new SupplierModel();
        $this->pageUtama = 'pages/admin/barang/data-barang';
        $this->uriUtama = 'admin/data-barang';

    }
    public function index()
    {
        $lastID = $this->barangModel->getLastID();
        if ($lastID == null) {
            $incrementId = 1; // Jika tidak ada ID sebelumnya, mulai dari 1
        } else {
            if (preg_match('/^BRG-(\d{3})$/', $lastID, $matches)) {
                $incrementId = intval($matches[1]) + 1; // Tambahkan 1 ke nilai numerik
            } else {
                // Jika format salah, fallback ke increment default
                $incrementId = 1; // Fallback jika format tidak sesuai
            }
        }
        $id_barang = 'BRG-'.str_pad($incrementId, 3, '0', STR_PAD_LEFT);
        $data = [
            'title' => 'Data Barang',
            'data_supplier' => $this->supplierModel->findAll(),
            'lastId' => $id_barang,
        ];
        return view($this->pageUtama,$data);
    }
    public function edit($id) {
        $barang = $this->barangModel->find($id);
        if (!$barang) {
            return redirect()->to('admin/data-barang')->with('error', 'User tidak ditemukan');
        }
        return view('pages/admin/barang/edit-barang', ['barang' => $barang]);
    }
    public function getBarang(){
        $barang = $this->barangModel->getBarangQuery();
        return DataTable::of($barang)
        ->addNumbering()
        ->add('aksi', function ($row) {
            return '<a href="' . site_url('admin/data-barang/edit/' . $row->id_barang) . '" class="btn btn-primary">Edit</a>
                   <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-id="' . $row->id_barang . '">Hapus</a>';
        })
        ->toJson();
    }
    public function getStokHampirHabis(){
        $barang = $this->barangModel->getStokHampirHabis();
        return $this->response->setJSON($barang);
    }
    
    public function save(){
        $data = $this->request->getPost();
        if ($this->barangModel->insert($data) !== false) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Barang berhasil disimpan'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Barang gagal disimpan'
            ]);
        }
    }
    public function update()
    {
        $barangID = $this->request->getPost('id_barang');
        $namaBarang = $this->request->getPost('nama_barang');
        $stok = $this->request->getPost('stok');
        $harga = $this->request->getPost('harga');

        // Cek apakah pengguna ada
        $supplier = $this->barangModel->find($barangID);
        if ($supplier) {
            // Update data pengguna
            $this->barangModel->update($barangID, [
                'nama_barang' => $namaBarang,
                'stok' => $stok,
                'harga' => $harga
            ]);
            return redirect()->to('admin/data-barang')
                ->with('success', 'Data Barang berhasil diubah');
        } else {
            return redirect()->to('admin/data-barang')
                ->with('error', 'Data Barang tidak ditemukan');
        }
}   
    public function delete($id){
        if($this->barangModel->delete($id)){
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Barang berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Barang gagal dihapus'
            ]);
        }
    }
}