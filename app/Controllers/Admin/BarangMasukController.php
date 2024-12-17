<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class BarangMasukController extends BaseController
{
    protected $barangMasukModel;
    protected $pageUtama;
    public function __construct() {
        $this->barangMasukModel = new BarangMasukModel();
        $this->pageUtama = 'pages/admin/barang-masuk/data-barang-masuk';
    }
    public function index()
    {
        $data = [
            'title' => 'Barang Masuk'
        ];
        
        return view($this->pageUtama, $data);
    }
    public function getBarangMasuk(){
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $data = $this->barangMasukModel->getBarangMasukQuery();
        if ($startDate && $endDate) {
            $data->where('tbl_barang_masuk.tanggal_masuk >=', $startDate)
                ->where('tbl_barang_masuk.tanggal_masuk <=', $endDate);
        }
        return DataTable::of($data)
            ->addNumbering()
            ->toJson();
    }
}