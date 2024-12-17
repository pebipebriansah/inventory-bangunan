<?php
$this->title = 'Data Barang';
$this->menu_active = 'master';
$this->nav_active = 'barang';
$this->extend('layout/layout-admin');
$this->section('content');
?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form action="<?= site_url('admin/data-barang/update') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id_barang" value="<?= esc($barang['id_barang']) ?>">

        <!-- Card for the form -->
        <div class="card shadow-sm">
            <h5 class="card-header">Edit Data Barang</h5>
            <div class="card-body">

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" class="form-control"
                        value="<?= esc($barang['nama_barang']) ?>" required>
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Stok</label>
                    <input type="number" id="stok" name="stok" class="form-control"
                        value="<?= esc($barang['stok']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Harga</label>
                    <input type="number" id="harga" name="harga" class="form-control"
                        value="<?= esc($barang['harga']) ?>" required>
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