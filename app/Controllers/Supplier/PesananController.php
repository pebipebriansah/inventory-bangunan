<?php

namespace App\Controllers\Supplier;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use CodeIgniter\HTTP\ResponseInterface;

class PesananController extends BaseController
{
    protected $pesananModel;
    public function __construct() {
        $this->pesananModel = new PesananModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Pesanan Supplier',
            'data_pesanan' => $this->pesananModel
            ->where('tbl_pesanan.id_supplier', session()->get('id_supplier'))
            ->join('tbl_supplier', 'tbl_supplier.id_supplier = tbl_pesanan.id_supplier')
            ->findAll(),
        ];
        return view('pages/supplier/data-pesanan',$data);
    }
    public function kirim($id){
        $data = [
            'status' => 'Barang Di Kirim'
        ];
        if($this->pesananModel->update($id, $data)){
            session()->setFlashdata('success', 'Pesanan berhasil dikirim');
            return redirect()->to('/supplier/data-pesanan');
        }else{
            session()->setFlashdata('error', 'Pesanan gagal dikirim');
            return redirect()->to('/supplier/data-pesanan');
        }
    }
}
