<?= $this->extend('layout/layout-admin') ?>
<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <?= $this->include('components/flash-messages') ?>
    <form action="<?= base_url('admin/data-user/edit/' . (int)$user->id_user) ?>" method="POST">
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                <span><?= $title ?></span>
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3">
                        <div>
                            <label for="nameWithTitle" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Enter Name" value="<?= $user->nama_lengkap ?>" />
                        </div>
                        <?php if (!empty($errors['nama_lengkap'])): ?>
                            <p class="text-danger form-error"><?= $errors['nama_lengkap'] ?></p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col mb-0">
                        <div>
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter Username" value="<?= $user->username ?>" />
                        </div>
                        <?php if (!empty($errors['username'])): ?>
                            <p class="text-danger form-error"><?= $errors['username'] ?></p>
                        <?php endif ?>
                    </div>
                    <div class="col mb-0">
                        <div>
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="***********" />
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <p class="text-danger form-error"><?= $errors['password'] ?></p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <div>
                            <label for="nameWithTitle" class="form-label">Role</label>
                            <select name="role" class="form-control">
                                <option value="">Silahkan Pilih</option>
                                <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="manager" <?= $user->role == 'manager' ? 'selected' : '' ?>>Manager</option>
                                <option value="gudang" <?= $user->role == 'gudang' ? 'selected' : '' ?>>Gudang</option>
                            </select>
                        </div>
                        <?php if (!empty($errors['role'])): ?>
                            <p class="text-danger form-error"><?= $errors['role'] ?></p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= base_url('admin/data-user') ?>" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>