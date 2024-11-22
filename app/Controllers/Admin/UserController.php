<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Data User',
            'data_pengguna' => $this->userModel->findAll()
        ];

        return view('pages/admin/data-user/index', $data);
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Data pengguna berhasil dihapus');
        return redirect()->to('/admin/data-user');
    }

    public function edit($id)
    {
        $errors = [];

        if (!$id) {
            $user = new User();
            $user->id_user = 0;
            $title = 'Tambah User';
        } else {
            $title = 'Edit User';
            $user = $this->userModel->find($id);

            // TODO: jangan perbolehkan edit akun admin
            // TODO: jangan perbolehkan edit akun sendiri
        }

        if (strtolower($this->request->getMethod()) == 'post') {
            $data = $this->request->getPost();

            if (empty($data['nama_lengkap'])) {
                $errors['nama_lengkap'] = 'Nama lengkap harus diisi.';
            }

            if (strlen($data['username']) < 3 || strlen($data['username']) > 40) {
                $errors['username'] = 'Username harus diisi. minimal 3 karakter, maksimal 40 karakter.';
            } else if (!preg_match('/^[a-zA-Z\d_]+$/i', $data['username'])) {
                $errors['username'] = 'Username tidak valid, gunakan huruf alfabet, angka dan underscore.';
            } else if ($this->userModel->exists($data['username'], $user->id_user)) {
                $errors['username'] = 'Username sudah digunakan, harap gunakan nama lain.';
            }

            if (empty($data['role'])) {
                $errors['role'] = 'Silahkan pilih role.';
            }

            if (!$id) {
                unset($user->id_user);
                if (empty($data['password'])) {
                    $errors['password'] = 'Password harus diisi';
                }
            }

            $password = $data['password'];
            unset($data['password']);
            $user->fill($data);

            if (empty($errors)) {
                // set password hanya jika nambah user atau ketika edit user dan passwordnya diisi
                if ($id == 0 || ($id != 0 && !empty($password))) {
                    $user->password = password_hash($password, PASSWORD_DEFAULT);
                }

                $this->userModel->save($user);

                return redirect()
                    ->to('/admin/data-user')
                    ->with('success', 'Data pengguna berhasil disimpan.');
            }
        }

        return view('pages/admin/data-user/edit', compact('title', 'user', 'errors'));
    }
}
