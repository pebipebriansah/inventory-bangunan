<?php
$this->title = 'Data User';
$this->menu_active = 'master';
$this->nav_active = 'user';
$this->extend('layout/layout-admin');
$this->section('content');
?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Toast Success -->
    <div class="toast" id="successToast" role="alert" aria-live="assertive" aria-atomic="true"
        style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <div class="toast-header">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Data pengguna berhasil disimpan!
        </div>
    </div>

    <!-- Toast Error -->
    <div class="toast" id="errorToast" role="alert" aria-live="assertive" aria-atomic="true"
        style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <div class="toast-header">
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Terjadi kesalahan saat menyimpan data pengguna.
        </div>
    </div>

    <!-- Tabel Data User -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data User</span>
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                data-bs-target="#addOrderModal">
                Tambah User
            </button>
        </h5>
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="table-responsive">
                <table id="data-user-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>ID User</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addOrderForm" method="POST" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                                    placeholder="Enter Name" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Username" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Password</label>
                                <input type="password" name="password" id="dobWithTitle" class="form-control"
                                    placeholder="***********" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Role</label>
                                <select name="role" class="form-control">
                                    <option value="#">Silahkan Pilih</option>
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="gudang">Gudang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- / Content -->
<?=$this->endSection()?>
<?=$this->section('script')?>
<script>
$('#addOrderForm').on('submit', function(e) {
    e.preventDefault();

    var form = $(this);
    if (form[0].checkValidity() === false) {
        e.stopPropagation();
    } else {
        var formData = form.serialize();
        $.ajax({
            url: '<?= base_url('admin/data-user/save') ?>',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Menampilkan Toast Success jika data berhasil disimpan
                const toastSuccess = new bootstrap.Toast(document.getElementById(
                    'successToast'));

                if (response.status === 'success') {
                    // Menyesuaikan pesan sesuai aksi
                    $('#toastSuccessBody').text('Data pengguna berhasil disimpan!');

                    // Tampilkan Toast
                    toastSuccess.show();

                    // Reset form dan tutup modal
                    $('#addOrderModal').modal('hide');
                    $('#addOrderForm')[0].reset();

                    // Reload the table data
                    $('#data-user-table').DataTable().ajax.reload();
                } else {
                    // Menampilkan Toast Error
                    const toastError = new bootstrap.Toast(document.getElementById(
                        'errorToast'));
                    $('#toastErrorBody').text(
                        'Terjadi kesalahan saat menyimpan data pengguna.');
                    toastError.show();
                }

                // Set timeout untuk menyembunyikan toast setelah 2 detik
                setTimeout(function() {
                    toastSuccess.hide();
                    toastError.hide();
                }, 2000);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }
    form.addClass('was-validated');
});
</script>
<script>
// Menutup toast setelah 2 detik
setTimeout(function() {
    let toastElement = document.querySelector('.toast');
    let toast = new bootstrap.Toast(toastElement);
    toast.hide(); // Menyembunyikan toast
}, 2000); // 2 detik
</script>
<script>
$(document).ready(function() {
    $('#data-user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= base_url('admin/data-user/get-user') ?>',
            type: 'POST'
        },
        destroy: true
    });
});
</script>
<script>
$(document).ready(function() {
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button yang memicu modal
        var userId = button.data('user-id'); // Ambil ID pengguna dari atribut data-*
        var modal = $(this);
        modal.find('.modal-body').text('Apakah Anda yakin ingin menghapus pengguna dengan ID ' +
            userId + '?');
        modal.find('form').attr('action', 'data-user/delete/' + userId);
    });

    // Handle delete form submission
    $('#deleteForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah pengiriman form default

        var form = $(this);
        var url = form.attr('action'); // Ambil URL dari form action

        $.ajax({
            url: url,
            type: 'POST',
            success: function(response) {
                if (response.status === 'success') {
                    // Menampilkan Toast sukses
                    showToast('Success', 'Data pengguna berhasil dihapus!');
                    // Tutup modal setelah penghapusan
                    $('#deleteModal').modal('hide');
                    // Reload tabel data user setelah penghapusan
                    $('#data-user-table').DataTable().ajax.reload();
                } else {
                    // Menampilkan Toast error
                    showToast('Error',
                        'Terjadi kesalahan saat menghapus data pengguna.');
                }
            },
            error: function(xhr, status, error) {
                showToast('Error', 'Terjadi kesalahan dalam permintaan!');
            }
        });
    });
});

// Fungsi untuk menampilkan Toast
function showToast(title, message) {
    var toastType = title.toLowerCase();
    var toastElement = $('#' + toastType + 'Toast');
    toastElement.find('.toast-header strong').text(title);
    toastElement.find('.toast-body').text(message);
    var toast = new bootstrap.Toast(toastElement[0]);
    toast.show();

    // Menyembunyikan toast setelah 2 detik
    setTimeout(function() {
        toast.hide();
    }, 2000);
}
</script>
<script>
$(document).ready(function() {
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var userId = button.data('user-id');
        var modal = $(this);

        $.ajax({
            url: '<?=base_url('getUserById/')?>' + userId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    alert('Error: ' + data.error);
                } else {
                    $('#userId').val(data.id);
                    $('#nama_lengkap').val(data.nama_lengkap);
                    $('#username').val(data.username);
                    $('#role').val(data.role);
                }
            },
            error: function(xhr, status, error) {
                alert('Gagal mengambil data pengguna: ' + error);
            }
        });
    });
});
</script>
<?=$this->endSection()?>