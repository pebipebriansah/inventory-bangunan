<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\BarangMasukModel;

class DashboardController extends BaseController
{
    public function index()
{    // Kirim data ke view
    $data = [
        'title' => 'Dashboard Admin',
    ];

    return view('pages/admin/dashboard_admin', $data);
}
    public function getChartData()
    {
        $request = service('request');
        $chartType = $request->getGet('type');

        $barangMasukModel = new BarangMasukModel();
        $penjualanModel = new PenjualanModel();

        if ($chartType === 'penjualan') {
            $data = $penjualanModel->getSalesData();
        } else {
            $data = $barangMasukModel->getLowStockData();
        }

        $response = [
            'labels' => array_column($data, 'nama_barang'),
            'data' => array_column($data, $chartType === 'penjualan' ? 'total_sold' : 'stok')
        ];

        return $this->response->setJSON($response);
    }
}
