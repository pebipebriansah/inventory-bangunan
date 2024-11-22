<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use CodeIgniter\HTTP\ResponseInterface;

class BarangKeluarController extends BaseController
{
    protected $barangKeluar;
    public function __construct() {
        $this->barangKeluar = new BarangKeluarModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Data Barang Keluar',
            'barang_keluar' => $this->barangKeluar
                ->select('tbl_barang_keluar.*, tbl_penjualan.*, tbl_barang.nama_barang') // Kolom tbl_barang.nama_barang yang benar
                ->join('tbl_penjualan', 'tbl_barang_keluar.id_penjualan = tbl_penjualan.id_penjualan') // Join dengan tbl_penjualan
                ->join('tbl_barang', 'tbl_penjualan.id_barang = tbl_barang.id_barang') // Join dengan tbl_barang
                ->findAll()
        ];
        return view('pages/admin/data-barang-keluar', $data);
    }
}