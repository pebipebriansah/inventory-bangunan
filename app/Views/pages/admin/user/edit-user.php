<?php
$this->title = 'Data User';
$this->menu_active = 'master';
$this->nav_active = 'user';
$this->extend('layout/layout-admin');
$this->section('content');
?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form action="<?= site_url(relativePath: 'admin/data-user/update') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id_user" value="<?= esc($user['id_user']) ?>">

        <!-- Card for the form -->
        <div class="card shadow-sm">
            <h5 class="card-header">Edit Data User</h5>
            <div class="card-body">

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                        value="<?= esc($user['nama_lengkap']) ?>" required>
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control"
                        value="<?= esc($user['username']) ?>" required>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="manager" <?= $user['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                        <option value="gudang" <?= $user['role'] == 'gudang' ? 'selected' : '' ?>>Gudang</option>
                    </select>
                </div>

                <!-- Button Submit -->
                <div class="mb-3 text-start">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?=$this->endSection()?>