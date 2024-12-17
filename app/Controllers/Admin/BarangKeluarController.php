<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class BarangKeluarController extends BaseController
{
    protected $barangKeluar;
    protected $pageUtama;
    public function __construct() {
        $this->barangKeluar = new BarangKeluarModel();
        $this->pageUtama = 'pages/admin/barang-keluar/data-barang-keluar';
    }
        public function index()
    {
        $data = [
            'title' => 'Data Barang Keluar',
        ];

        return view($this->pageUtama, $data);
    }
    public function getBarangKeluar() {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $data = $this->barangKeluar->getBarangKeluarQuery();
        if ($startDate && $endDate) {
            $data->where('tbl_barang_keluar.tanggal_keluar >=', $startDate)
                ->where('tbl_barang_keluar.tanggal_keluar <=', $endDate);
        }
        return DataTable::of($data)
            ->addNumbering()
            ->toJson();
    }


}