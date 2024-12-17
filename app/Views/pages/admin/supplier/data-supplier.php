<?php
$this->title = 'Data Supplier';
$this->menu_active = 'master';
$this->nav_active = 'supplier';
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
    <!-- Tabel Data Supplier -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data Supplier</span>
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                data-bs-target="#addOrderModal">
                Tambah Supplier
            </button>
        </h5>
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="table-responsive">
                <table id="data-supplier-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>ID Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Kategori</th>
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
                    <h5 class="modal-title" id="deleteModalLabel">Delete Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Supplier?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        <input type="hidden" id="deleteSupplierId" name="supplier_id">
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
                                <label for="nameWithTitle" class="form-label">ID Supplier</label>
                                <input type="text" name="id_supplier" id="id_supplier" readonly value="<?= $last_id ?>"
                                    class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Supplier</label>
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control"
                                    placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat"
                                    placeholder="Enter Alamat"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="#">Silahkan Pilih</option>
                                    <option value="Alat">Alat</option>
                                    <option value="Kelistrikan">Kelistrikan</option>
                                    <option value="Bahan Bangunan">Bahan Bangunan</option>
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
    <!-- / Content -->
    <?= $this->endSection() ?>
    <?= $this->section('script') ?>
    <script>
    $(document).ready(function() {
        $('#data-supplier-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/data-supplier/get-supplier') ?>',
                type: 'POST'
            },
            destroy: true
        });
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
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button yang memicu modal
            var supplierID = button.data('supplier-id'); // Ambil ID pengguna dari atribut data-*
            var modal = $(this);
            modal.find('.modal-body').text('Apakah Anda yakin ingin menghapus supplier dengan ID ' +
                supplierID + '?');
            modal.find('form').attr('action', 'data-supplier/delete/' + supplierID);
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
                        showToast('Success', 'Data Supplier berhasil dihapus!');
                        // Tutup modal setelah penghapusan
                        $('#deleteModal').modal('hide');
                        // Reload tabel data user setelah penghapusan
                        $('#data-supplier-table').DataTable().ajax.reload();
                    } else {
                        // Menampilkan Toast error
                        showToast('Error',
                            'Terjadi kesalahan saat menghapus data Supplier.');
                    }
                },
                error: function(xhr, status, error) {
                    showToast('Error', 'Terjadi kesalahan dalam permintaan!');
                }
            });
        });
    });

    // Fungsi untuk menampilkan Toast
    function showToast(type, message) {
        var toastType = type.toLowerCase();
        var toastElement = $('#' + toastType + 'Toast');
        toastElement.find('.toast-header strong').text(type);
        toastElement.find('.toast-body').text(message);
        var toast = new bootstrap.Toast(toastElement[0]);
        toast.show();

        setTimeout(function() {
            toast.hide();
        }, 2000); // Hide after 2 seconds
    }
    </script>
    <script>
    $('#addOrderForm').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        if (form[0].checkValidity() === false) {
            e.stopPropagation();
        } else {
            var formData = form.serialize();
            $.ajax({
                url: '<?= base_url('admin/data-supplier/save') ?>',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response); 
                    if (response.status === 'success') {
                        showToast('Success', 'Data Supplier berhasil disimpan!');
                        $('#addOrderModal').modal('hide');
                        $('#addOrderForm')[0].reset();
                        $('#data-supplier-table').DataTable().ajax.reload();
                    } else {
                        showToast('Error', 'Terjadi kesalahan saat menyimpan data Supplier.');
                    }

                    // Hide toasts after 2 seconds
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
    <?= $this->endSection() ?>