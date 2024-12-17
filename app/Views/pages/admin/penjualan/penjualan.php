<?php
$this->title = 'Transaksi Penjualan';
$this->menu_active = 'transaksi';
$this->nav_active = 'penjualan';
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
    <div class="card">
        <!-- Search and Filter Section -->
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data Penjualan</span>
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                data-bs-target="#addOrderModal">
                Tambah Penjualan
            </button>
        </h5>
        <div class="card-body">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-penjualan-table"
                        class="table table-striped table-hover table-bordered align-middle">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Actions</th>
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
                        <h5 class="modal-title" id="deleteModalLabel">Delete Penjualan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Penjualan?</p>
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
        <!-- Modal -->
        <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="addOrderForm" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="id_barang" class="form-label">Nama Barang</label>
                                    <select name="id_barang" id="id_barang" class="form-control">
                                        <option value="#">Silahkan Pilih</option> <!-- Tetap di atas -->
                                        <?php foreach($barang as $br) : ?>
                                        <option value="<?= $br['id_barang'] ?>" data-harga="<?=$br['harga']?>">
                                            <?= $br['nama_barang'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label class="form-label">Qty</label>
                                    <input type="text" name="qty" id="qty" class="form-control"
                                        placeholder="Enter Stok" />
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Harga</label>
                                    <input type="text" name="harga" id="harga" class="form-control"
                                        placeholder="Contoh 150.000" readonly />
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Total</label>
                                    <input type="text" name="total" id="total" class="form-control"
                                        placeholder="Contoh 150.000" readonly />
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
            $('#data-penjualan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('admin/data-penjualan/get-penjualan') ?>',
                    type: 'POST'
                }
            });
        });
        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const idBarang = document.getElementById('id_barang');
            const hargaInput = document.getElementById('harga');
            const qtyInput = document.getElementById('qty');
            const totalInput = document.getElementById('total');

            // Event listener untuk ketika item dipilih
            idBarang.addEventListener('change', function() {
                const selectedOption = idBarang.options[idBarang.selectedIndex];
                const harga = selectedOption.getAttribute(
                'data-harga'); // Ambil harga dari atribut data-harga

                if (harga) {
                    hargaInput.value = parseFloat(harga).toLocaleString('id-ID'); // Format ke rupiah
                } else {
                    hargaInput.value = '';
                }

                // Reset total ketika id_barang berubah
                totalInput.value = '';
            });

            // Event listener untuk ketika qty diisi
            qtyInput.addEventListener('input', function() {
                const qty = parseFloat(qtyInput.value) || 0; // Konversi ke angka atau default ke 0
                const harga = parseFloat(hargaInput.value.replace(/\./g, '').replace(/,/g, '')) ||
                0; // Hilangkan format rupiah

                if (harga && qty) {
                    const total = qty * harga;
                    totalInput.value = total.toLocaleString('id-ID'); // Format ke rupiah
                } else {
                    totalInput.value = '';
                }
            });
        });
        </script>

        <script>
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button yang memicu modal
                var penjualanID = button.data('penjualan-id'); // Ambil ID pengguna dari atribut data-*
                var modal = $(this);
                modal.find('.modal-body').text(
                    'Apakah Anda yakin ingin menghapus Penjualan dengan ID ' +
                    penjualanID + '?');
                modal.find('form').attr('action', 'data-penjualan/delete/' + penjualanID);
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
                            showToast('Success', 'Data Penjualan berhasil dihapus!');
                            // Tutup modal setelah penghapusan
                            $('#deleteModal').modal('hide');
                            // Reload tabel data user setelah penghapusan
                            $('#data-penjualan-table').DataTable().ajax.reload();
                        } else {
                            // Menampilkan Toast error
                            showToast('Error',
                                'Terjadi kesalahan saat menghapus data Penjualan.');
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
        $('#addOrderForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            if (form[0].checkValidity() === false) {
                e.stopPropagation();
            } else {
                var formData = form.serialize();
                $.ajax({
                    url: '<?= base_url('admin/data-penjualan/save') ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast('Success', 'Data Penjualan berhasil disimpan!');

                            // Reset form dan tutup modal
                            $('#addOrderModal').modal('hide');
                            $('#addOrderForm')[0].reset();

                            // Reload the table data
                            $('#data-penjualan-table').DataTable().ajax.reload();
                        } else {
                            showToast('Error', 'Terjadi kesalahan saat menyimpan data Penjualan.');
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
        </script>
        <?=$this->endSection()?>