<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use CodeIgniter\HTTP\ResponseInterface;

class BarangMasukController extends BaseController
{
    protected $barangMasukModel;
    public function __construct() {
        $this->barangMasukModel = new BarangMasukModel();
    }
    public function index()
    {
        
        $data = [
            'title' => 'Barang Masuk',
            'barang_masuk' => $this->barangMasukModel
                ->select('tbl_barang_masuk.*, tbl_pesanan.*, tbl_supplier.nama_supplier') // Pilih kolom yang dibutuhkan
                ->join('tbl_pesanan', 'tbl_barang_masuk.id_pesanan = tbl_pesanan.id_pesanan') // Join dengan tbl_pesanan
                ->join('tbl_supplier', 'tbl_pesanan.id_supplier = tbl_supplier.id_supplier') // Join dengan tabel supplier
                ->findAll()
        ];
        
        return view('pages/admin/data-barang-masuk', $data);
    }
}
