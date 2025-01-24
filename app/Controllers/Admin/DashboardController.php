<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BarangModel;
use App\Models\PenjualanModel;

class DashboardController extends BaseController
{
    public function index()
{    // Kirim data ke view
    $data = [
        'title' => 'Dashboard Admin',
       
    ];

    return view('pages/admin/dashboard_admin', $data);
}

}
