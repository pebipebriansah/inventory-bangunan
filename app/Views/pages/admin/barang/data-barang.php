<?php
$this->title = 'Data Barang';
$this->menu_active = 'master';
$this->nav_active = 'barang';
$this->extend('layout/layout-admin');
$this->section('content');
?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="toast" id="successToast" role="alert" aria-live="assertive" aria-atomic="true"
        style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <div class="toast-header">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Data Penjualan berhasil disimpan!
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
            Terjadi kesalahan saat menyimpan data Penjualan.
        </div>
    </div>
    <!-- Tabel Data Barang -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data Barang</span>
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                data-bs-target="#addOrderModal">
                Tambah Barang
            </button>
        </h5>
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="table-responsive">
                <table id="data-barang-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Supplier</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id="pagination-container" class="mt-3"></div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Barang?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        <input type="hidden" id="deleteBarangId" name="barang_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="POST" action="<?=base_url('admin/data-barang/update')?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Edit Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="idUser" class="form-label">ID Barang</label>
                            <input type="text" id="idBarang" name="id_barang" class="form-control" readonly />
                        </div>
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Barang</label>
                            <input type="text" id="namaBarang" name="nama_barang" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Stok</label>
                            <input type="text" id="stok" name="stok" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Harga</label>
                            <input type="text" id="harga" name="harga" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Supplier</label>
                            <select id="id_supplier" name="id_supplier" class="form-control">
                                <?php foreach ($data_supplier as $supplier) : ?>
                                <option value="<?= htmlspecialchars($supplier['id_supplier'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?= htmlspecialchars($supplier['nama_supplier'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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
                                <label for="nameWithTitle" class="form-label">ID Barang</label>
                                <input type="text" name="id_barang" id="id_barang" readonly value="<?=$lastId?>"
                                    class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" id="namaBarang" class="form-control"
                                    placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label class="form-label">Stok</label>
                                <input type="text" name="stok" id="stok" class="form-control"
                                    placeholder="Enter Stok" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Harga</label>
                                <input type="text" name="harga" id="harga" class="form-control"
                                    placeholder="Contoh 150.000" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Supplier</label>
                                <select id="id_supplier" name="id_supplier" class="form-control">
                                    <option value="">Pilih Supplier</option>
                                    <?php foreach ($data_supplier as $supplier) : ?>
                                    <option
                                        value="<?= htmlspecialchars($supplier['id_supplier'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= htmlspecialchars($supplier['nama_supplier'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                    <?php endforeach; ?>
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
    <?=$this->endSection()?>
    <?=$this->section('script')?>
    <script>
    setTimeout(function() {
        let toastElement = document.querySelector('.toast');
        let toast = new bootstrap.Toast(toastElement);
        toast.hide(); // Menyembunyikan toast
    }, 2000); // 2 detik
    </script>
    <script>
    $(document).ready(function() {
        $('#data-barang-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/data-barang/get-barang') ?>',
                type: 'POST'
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var userId = button.data('user-id') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('.modal-body').text('Apakah Anda yakin ingin menghapus barang dengan ID ' +
                userId + '?')
            modal.find('form').attr('action', 'data-barang/delete/' + userId);
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
                        showToast('Success', 'Data Barang berhasil dihapus!');
                        // Tutup modal setelah penghapusan
                        $('#deleteModal').modal('hide');
                        // Reload tabel data user setelah penghapusan
                        $('#data-barang-table').DataTable().ajax.reload();
                    } else {
                        // Menampilkan Toast error
                        showToast('Error',
                            'Terjadi kesalahan saat menghapus data barang.');
                    }
                },
                error: function(xhr, status, error) {
                    showToast('Error', 'Terjadi kesalahan dalam permintaan!');
                }
            });
        });
    });
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
                url: '<?= base_url('admin/data-barang/save') ?>',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        showToast('Success', 'Data Barang berhasil disimpan!');

                        // Reset form dan tutup modal
                        $('#addOrderModal').modal('hide');
                        $('#addOrderForm')[0].reset();

                        // Reload the table data
                        $('#data-barang-table').DataTable().ajax.reload();
                    } else {
                        showToast('Error', 'Terjadi kesalahan saat menyimpan data Barang.');
                    }
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

    $(document).ready(function() {
        <?php if (session()->getFlashdata('success')) : ?>
        showToast('Success', '<?= session()->getFlashdata('success') ?>');
        <?php endif ?>
        <?php if (session()->getFlashdata('error')) : ?>
        showToast('Error', '<?= session()->getFlashdata('error') ?>');
        <?php endif ?>
    });
    </script>
    <?=$this->endSection()?>