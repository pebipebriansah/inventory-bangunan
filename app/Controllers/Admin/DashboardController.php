<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;
use App\Models\PenjualanModel;

class DashboardController extends BaseController
{
    public function index()
{
    // Load model untuk barang dan penjualan
    $barangModel = new BarangModel();
    $penjualanModel = new PenjualanModel();

    // Ambil semua barang
    $barangList = $barangModel->findAll();

    // Variabel untuk menyimpan rekomendasi stok optimal dan stok menipis
    $barangRekomendasi = [];
    $stokMenipis = [];

    // Loop untuk menghitung rekomendasi stok dan cek stok menipis untuk setiap barang
    foreach ($barangList as $barang) {
        // Ambil total penjualan untuk barang ini
        $totalPenjualan = $penjualanModel->getTotalPenjualan($barang['id_barang']);

        // Hitung stok optimal berdasarkan rata-rata penjualan dan buffer 20%
        $stokOptimal = ceil($totalPenjualan * 1.2);

        // Simpan rekomendasi stok dalam array
        $barangRekomendasi[] = [
            'nama_barang' => $barang['nama_barang'],
            'stok_terjual' => $totalPenjualan,
            'stok_optimal' => $stokOptimal
        ];

        // Cek apakah stok barang kurang dari 40
        if ($barang['stok'] < 40) {
            $stokMenipis[] = [
                'nama_barang' => $barang['nama_barang'],
                'stok_sekarang' => $barang['stok'],
                'stok_minimum' => 40, // Batas minimum
                'rekomendasi_pesan' => max(40 - $barang['stok'], 0) // Jumlah yang harus dipesan untuk mencapai stok minimum
            ];
        }
    }

    // Kirim data ke view
    $data = [
        'title' => 'Dashboard Admin',
        'barang_rekomendasi' => $barangRekomendasi,
        'stok_menipis' => $stokMenipis
    ];

    return view('pages/admin/dashboard_admin', $data);
}

}
