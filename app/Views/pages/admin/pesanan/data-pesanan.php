<?php
$this->title = 'Data Pesanan';
$this->menu_active = 'master';
$this->nav_active = 'pesanan';
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
    <!-- Tabel Data Pesanan -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data Pesanan</span>
            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                data-bs-target="#addOrderModal">
                Tambah Pesanan
            </button>
        </h5>
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="search-input" class="form-control" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive">
                <table id="data-pesanan-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_pesanan)): ?>
                        <tr>
                            <td colspan="8" class="text-center">No data available</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($data_pesanan as $pesanan): ?>
                        <tr>
                            <td><?= $pesanan['id_pesanan']; ?></td>
                            <td><?= $pesanan['nama_barang']; ?></td>
                            <td><?= $pesanan['jumlah']; ?></td>
                            <td><?= $pesanan['harga']; ?></td>
                            <td><?= $pesanan['total']; ?></td>
                            <td><?= $pesanan['nama_supplier']; ?></td>
                            <td><?= $pesanan['status']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php if ($pesanan['status'] == 'Menunggu Konfirmasi'): ?>
                                        <?php if(session()->get('role') == 'manager'): ?>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#konfirmasiModal<?=$pesanan['id_pesanan']?>"
                                                data-id="<?=$pesanan['id_pesanan']?>"
                                                onclick="setConfirmModalData(this)">
                                                <i class="bx bx-lock-open-alt me-2"></i> Konfirmasi
                                            </a>
                                        </li>
                                        <?php endif;?>
                                        <?php elseif ($pesanan['status'] == 'Barang Di Pesan'): ?>
                                        <li>
                                            <?php if(session()->get('role') == 'gudang'): ?>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#terimaModal<?=$pesanan['id_pesanan']?>"
                                                data-id="<?=$pesanan['id_pesanan']?>"
                                                onclick="setTerimaModalData(this)">
                                                <i class="bx bx-check me-2"> Terima Barang</i>
                                            </a>
                                        </li>
                                        <?php endif;?>
                                        <?php elseif ($pesanan['status'] == 'Barang Diterima'): ?>
                                        <?php if(session()->get('role') == 'gudang'): ?>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#masukModal<?=$pesanan['id_pesanan']?>"
                                                data-id="<?=$pesanan['id_pesanan']?>" onclick="setMasukModalData(this)">
                                                <i class="bx bx-move me-2"></i> Move To Barang Masuk
                                            </a>
                                        </li>
                                        <?php endif;?>
                                        <?php endif;?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div id="pagination-container" class="mt-3"></div>
        </div>
    </div>

    <!-- Modal Delete -->
    <?php foreach($data_pesanan as $pesanan):?>
    <div class="modal fade" id="deleteModal<?=$pesanan['id_pesanan']?>" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
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
                    <form id="deleteForm" method="POST"
                        action="<?=base_url('admin/data-pesanan/delete/').$pesanan['id_pesanan']?>">
                        <input type="hidden" id="deleteId" name="id_pesanan">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Terima Modal -->
    <div class="modal fade" id="terimaModal<?=$pesanan['id_pesanan']?>" tabindex="-1" aria-labelledby="terimaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="terimaModalLabel">Terima Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Menerima Pesanan Ini ?</p>
                </div>
                <div class="modal-footer">
                    <form id="confirmForm" method="POST"
                        action="<?=base_url('admin/data-pesanan/terima/').$pesanan['id_pesanan']?>">
                        <input type="hidden" id="terimaId" name="id_pesanan">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Masuk Modal -->
    <div class="modal fade" id="masukModal<?=$pesanan['id_pesanan']?>" tabindex="-1" aria-labelledby="masukModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="masukModalLabel">Terima Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Masukan Barang Ini ?</p>
                </div>
                <div class="modal-footer">
                    <form id="confirmForm" method="POST"
                        action="<?=base_url('admin/data-pesanan/masuk/').$pesanan['id_pesanan']?>">
                        <input type="hidden" id="terimaId" name="id_pesanan">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Konfirmasi Modal -->
    <div class="modal fade" id="konfirmasiModal<?=$pesanan['id_pesanan']?>" tabindex="-1"
        aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Yakin Ingin Mengkonfirmasi Pemesanan Ini ?</p>
                </div>
                <div class="modal-footer">
                    <form id="confirmForm" method="POST"
                        action="<?=base_url('admin/data-pesanan/konfirmasi/').$pesanan['id_pesanan']?>">
                        <input type="hidden" id="konfirmasiId" name="id_pesanan">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach?>
    <!-- Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addOrderForm" method="POST" action="<?=base_url('admin/data-pesanan/save')?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                <select name="id_barang" id="id_barang" class="form-control">
                                    <option value="#">Silahkan Pilih</option>
                                    <?php if (!empty($barang)): ?>
                                    <?php foreach($barang as $br): ?>
                                    <option value="<?= $br['id_barang']; ?>"><?= $br['nama_barang']; ?></option>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <option value="#" disabled>Stok tidak tersedia untuk pembelian</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <input type="hidden" name="nama_barang" id="nama_barang">
                            <input type="hidden" name="id_supplier" id="id_supplier">
                        </div>
                        <div class="row g-3">
                            <div class="col mb-0">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control"
                                    placeholder="Enter Jumlah" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Harga</label>
                                <input type="text" name="harga" id="harga" class="form-control" readonly />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Total</label>
                                <input type="text" name="total" id="total" class="form-control" readonly />
                            </div>
                        </div>
                        <div id="perhitungan"></div>
                        <div id="kesimpulan"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary" <?php if (empty($barang)) echo 'disabled'; ?>>Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <?=$this->endSection()?>
    <?=$this->section('script')?>
    <script>
    // Function to set data for Delete Modal
    function setDeleteModalData(button) {
        const pesananId = button.getAttribute('data-id');
        document.getElementById('deleteId').value = pesananId;
    }

    function setConfirmModalData(button) {
        const pesananId = button.getAttribute('data-id');
        document.getElementById('konfirmasiId').value = pesananId;
    }

    function setMasukModalData(button) {
        const pesananId = button.getAttribute('data-id');
        document.getElementById('masukId').value = pesananId;
    }

    function setTerimaModalData(button) {
        const pesananId = button.getAttribute('data-id');
        document.getElementById('terimaId').value = pesananId;
    }

    function setEditModalData(button) {
        // Ambil data ID dari atribut data-id
        const userId = button.getAttribute('data-id');

        // Ambil data lainnya dari atribut data-user (dalam JSON)
        const userData = JSON.parse(button.getAttribute('data-user'));

        // Isi field pada modal dengan data
        document.querySelector('#editModal #idUser').value = userId; // dari data-id
        document.querySelector('#editModal #namaLengkap').value = userData.nama_lengkap;
        document.querySelector('#editModal #username').value = userData.username;
        document.querySelector('#editModal #password').value = userData.password;
        document.querySelector('#editModal #role').value = userData.role;
    }
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
        // Event saat id_barang berubah
        $('#id_barang').change(function() {
            const selectedId = $(this).val();
            if (selectedId) {
                // Lakukan permintaan AJAX ke controller untuk mendapatkan data barang dan penjualan
                $.ajax({
                    url: `<?=base_url('get-barang/');?>${selectedId}`, // Gunakan backticks
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.nama_barang && data.id_supplier && data.harga) {
                            // Isi form dengan data barang
                            $('#nama_barang').val(data.nama_barang);
                            $('#id_supplier').val(data.id_supplier);
                            $('#harga').val(data.harga);
                            $('#total').val('');

                            // Lakukan permintaan tambahan untuk menghitung stok penjualan
                            $.ajax({
                                url: `<?=base_url('get-total-penjualan/');?>${selectedId}`, // Endpoint untuk data penjualan
                                type: 'GET',
                                dataType: 'json',
                                success: function(salesData) {
                                    if (salesData && salesData.total_qty) {
                                        const totalQty = salesData.total_qty;

                                        // Hitung rata-rata penjualan harian
                                        const daysInMonth =
                                            30; // Misal satu bulan di sini diasumsikan 30 hari
                                        const avgDailySales = totalQty /
                                            daysInMonth;

                                        // Buffer untuk penyesuaian stok (misalnya 20%)
                                        const buffer = 0.2;
                                        const leadTime =
                                            4; // Waktu pengadaan barang (misal 7 hari)

                                        // Prediksi stok optimal
                                        const optimalStock = Math.ceil(
                                            avgDailySales * (daysInMonth +
                                                leadTime) * (1 + buffer)
                                        );

                                        // Tampilkan perhitungan dan prediksi stok optimal di textview
                                        $('#perhitungan').html(`
                                        <p><strong>Perhitungan Stok Optimal:</strong></p>
                                        <p>Total Penjualan Bulanan: ${totalQty} unit</p>
                                        <p>Rata-rata Penjualan Harian: ${avgDailySales.toFixed(2)} unit</p>
                                        <p>Buffer Stok: ${buffer * 100}%</p>
                                        <p>Lead Time (Hari Pengadaan): ${leadTime} hari</p>
                                        <p><strong>Prediksi Stok Optimal: ${optimalStock} unit</strong></p>
                                    `);

                                        // Kesimpulan
                                        let kesimpulan = '';
                                        if (optimalStock > totalQty) {
                                            kesimpulan =
                                                'Stok yang dibutuhkan lebih tinggi dari penjualan bulanan untuk mengantisipasi permintaan.';
                                        } else if (optimalStock < totalQty) {
                                            kesimpulan =
                                                'Stok yang dibutuhkan lebih rendah dari penjualan bulanan, perlu penyesuaian untuk mencegah kehabisan stok.';
                                        } else {
                                            kesimpulan =
                                                'Stok optimal sudah sesuai dengan penjualan bulanan.';
                                        }

                                        $('#kesimpulan').html(`
                                        <p><strong>Kesimpulan:</strong></p>
                                        <p>${kesimpulan}</p>
                                    `);
                                    } else {
                                        $('#perhitungan').html(
                                            'Data penjualan tidak tersedia.'
                                        );
                                        $('#kesimpulan').html(
                                            'Kesimpulan tidak dapat dihitung karena data tidak lengkap.'
                                        );
                                    }
                                },
                                error: function() {
                                    alert('Gagal menghitung total penjualan.');
                                }
                            });
                        } else {
                            alert('Data barang tidak lengkap.');
                        }
                    },
                    error: function() {
                        alert('Gagal mengambil data barang.');
                    }
                });
            } else {
                // Kosongkan semua input jika tidak ada barang yang dipilih
                $('#nama_barang').val('');
                $('#id_supplier').val('');
                $('#harga').val('');
                $('#total').val('');
                $('#prediksi_stok').val('');
                $('#perhitungan').html('');
                $('#kesimpulan').html('');
            }
        });
        // Hitung total saat jumlah diinputkan
        $('#jumlah').on('input', function() {
            const jumlah = parseInt($(this).val()) || 0;
            const harga = parseInt($('#harga').val()) || 0;
            const total = jumlah * harga;
            $('#total').val(total);
        });
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