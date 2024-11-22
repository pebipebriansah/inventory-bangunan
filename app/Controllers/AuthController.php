<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $userModel;
    public function __construct() {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Login Toko Bangunan'
        ];
        return view('login', $data);
    }
    public function auth(){
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $this->userModel->where('username', $username)->first();
        if($user){
            if(password_verify($password, $user['password'])){
                $data = [
                    'id_user' => $user['id_user'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ];
                session()->set($data);

                $redirectUrl = base_url();
                if($user['role'] == 'admin'){
                    $redirectUrl = base_url('admin');
                }else if($user['role'] == 'manager'){
                    $redirectUrl = base_url('admin');
                }else if($user['role'] == 'gudang'){
                    $redirectUrl = base_url('admin');
                }

                session()->setFlashdata('success','Login Berhasil');
                return redirect()->to($redirectUrl);
            }else{
                session()->setFlashdata('error','Password Salah');
                return redirect()->to(base_url('/'));
            }
        }else{
            session()->setFlashdata('error','Email Tidak Ditemukan');
            return redirect()->to(base_url('/'));
        }
    }
    public function register(){
        $data = [
            'title' => 'Halaman Register'
        ];
        return view('register', $data);
    }
    public function save(){
        $nama_lengkap = $this->request->getPost('nama_lengkap');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost(index: 'password');
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'username' => $username,
            'password' => password_hash($password,PASSWORD_DEFAULT),
            'role' => 1
        ];
        $this->userModel->insert($data);
        session()->setFlashdata('success','Registrasi Berhail');
        return redirect()->to(base_url('/'));
    }
    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }
}
