<?php
$this->title = 'Data Supplier';
$this->menu_active = 'master';
$this->nav_active = 'supplier';
$this->extend('layout/layout-admin');
$this->section('content');
?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form action="<?= site_url('admin/data-supplier/update') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id_supplier" value="<?= esc($supplier['id_supplier']) ?>">

        <!-- Card for the form -->
        <div class="card shadow-sm">
            <h5 class="card-header">Edit Data Supplier</h5>
            <div class="card-body">

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Supplier</label>
                    <input type="text" id="nama_supplier" name="nama_supplier" class="form-control"
                        value="<?= esc($supplier['nama_supplier']) ?>" required>
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control"
                        value="<?= esc($supplier['alamat']) ?>" required>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="Alat" <?= $supplier['kategori'] == 'Alat' ? 'selected' : '' ?>>Alat</option>
                        <option value="Bahan Bangunan" <?= $supplier['kategori'] == 'Bahan Bangunan' ? 'selected' : '' ?>>Bahan Bangunan</option>
                        <option value="Kelistrikan" <?= $supplier['kategori'] == 'Kelistrikan' ? 'selected' : '' ?>>kelistrikan</option>
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