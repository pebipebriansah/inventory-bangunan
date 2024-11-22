<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;
    public function __construct() {
        $this->userModel= new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Data User',
            'data_pengguna' => $this->userModel->findAll()
        ];
        return view('pages/admin/data-user',$data);
    }
    public function delete($id){
        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Data pengguna berhasil dihapus');
        return redirect()->to('/admin/data-user');
    }
    public function update($id){
        $dataInput = $this->request->getPost();
        $user = $this->userModel->find($id);
        if(empty($data['password'])){
            $data['password'] = $user['password'];
        }else{
            $data['password'] = password_hash($dataInput['password'], PASSWORD_DEFAULT);
        }
        $this->userModel->update($id, $data);
        session()->setFlashdata('success', 'Data pengguna berhasil diubah');
        return redirect()->to('/admin/data-user');
    }
    public function save(){
        $dataInput = $this->request->getPost();
        $data = [
            'nama_lengkap' => $dataInput['nama_lengkap'],
            'username' => $dataInput['username'],
            'password' => password_hash($dataInput['password'], PASSWORD_DEFAULT),
            'role' => $dataInput['role']
        ];
        if($this->userModel->insert($data) == true){
            session()->setFlashdata('success', 'Data pengguna berhasil disimpan');
        return redirect()->to('/admin/data-user');
        }else{
            session()->setFlashdata('error', 'Data pengguna gagal disimpan');
            return redirect()->to('/admin/data-user/save');
        }
        
    }
}