<?php

namespace App\Controllers\Supplier;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $supplierModel;
    public function __construct() {
        $this->supplierModel = new SupplierModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Supplier Login',
        ];
        return view('pages/supplier/login',$data);
    }
    public function auth(){
        $data = $this->request->getPost();
        $supplier = $this->supplierModel->where('username', $data['username'])->first();
        if($supplier){
            if(password_verify($data['password'], $supplier['password'])){
                $dataLogin = [
                    'id_supplier' => $supplier['id_supplier'],
                    'username' => $supplier['username'],
                    'kategori' => $supplier['kategori'],
                    'nama_supplier' => $supplier['nama_supplier'],
                    'logged_in' => TRUE,
                ];
                session()->set($dataLogin);
                session()->setFlashdata('success','Login Berhasil');
                return redirect()->to(base_url('supplier/dashboard'));
            }else{
                session()->setFlashdata('error','Password Salah');
                return redirect()->to(base_url('supplier/'));
            }
        }else{
            session()->setFlashdata('error','Username Tidak Ditemukan');
            return redirect()->to(base_url('supplier/'));
        }
    }
    public function logout(){
        session()->destroy();
        return redirect()->to(base_url('supplier/'));
    }
}
