<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;
    protected $pageUtama;
    protected $uriUtama;
    public function __construct() {
        $this->userModel= new UserModel();
        $this->pageUtama= 'pages/admin/user/data-user';
        $this->uriUtama= 'admin/data-user';
    }
    public function index()
    {
        $data = [
            'title' => 'Data User',
        ];
        return view($this->pageUtama,$data);

    }
    public function getUser(){
        $query = $this->userModel->getUserQuery();
        return DataTable::of($query)
        ->addNumbering()
        ->add('aksi', function ($row) {
            return '<a href="' . site_url('admin/data-user/edit/' . $row->id_user) . '" class="btn btn-primary">Edit</a>
                   <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-id="' . $row->id_user . '">Hapus</a>';
        })
        ->toJson();
    }
    public function getById($id)
{
    $user = $this->userModel->find($id);
    return $this->response->setJSON($user);
}
    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data pengguna berhasil dihapus!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data pengguna.'
            ]);
        }
    }
    public function edit($id_user)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id_user);

        if (!$user) {
            return redirect()->to('admin/data-user')->with('error', 'User tidak ditemukan');
        }

        return view('pages/admin/user/edit-user', ['user' => $user]);
    }
    public function update()
{
    $userId = $this->request->getPost('id_user');
    $namaLengkap = $this->request->getPost('nama_lengkap');
    $username = $this->request->getPost('username');
    $role = $this->request->getPost('role');
    $userModel = new UserModel();

    // Cek apakah pengguna ada
    $user = $userModel->find($userId);
    if ($user) {
        // Update data pengguna
        $userModel->update($userId, [
            'nama_lengkap' => $namaLengkap,
            'username' => $username,
            'role' => $role
        ]);
        return redirect()->to('admin/data-user')->with('success', 'Data pengguna berhasil diperbarui');
    } else {
        return redirect()->to('admin/data-user')->with('error', 'Data pengguna tidak ditemukan');
    }
}

    public function save() {
        $dataInput = $this->request->getPost();
        // Persiapkan data
        $data = [
            'nama_lengkap' => $dataInput['nama_lengkap'],
            'username' => $dataInput['username'],
            'password' => password_hash($dataInput['password'], PASSWORD_DEFAULT),
            'role' => $dataInput['role']
        ];
        
        // Menyimpan data
        if ($this->userModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data pengguna berhasil disimpan'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data pengguna gagal disimpan'
            ]);
            
        }
    }
    
}