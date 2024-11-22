<?=$this->extend('layout/layout-admin')?>
<?=$this->section('content')?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <?php if (session()->getFlashdata('success')) :?>
    <div class="bs-toast toast fade show bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Success</div>
            <small id="toast-timestamp"><?= date('H:i:s'); ?></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?= session()->getFlashdata('success');?></div>
    </div>
    <?php endif;?>
    <?php if (session()->getFlashdata('error')) :?>
    <div class="bs-toast toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Error</div>
            <small id="toast-timestamp"><?= date('H:i:s'); ?></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?= session()->getFlashdata('error');?></div>
    </div>
    <?php endif;?>
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
                <div class="col-md-6 text-end">
                    <button id="print-button" class="btn btn-primary">Print</button>
                    <button id="download-button" class="btn btn-success">Download</button>
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
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?=$pesanan['id_pesanan']?>"
                                                data-id="<?=$pesanan['id_pesanan']?>"
                                                onclick="setDeleteModalData(this)">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </li>
                                        <?php elseif ($pesanan['status'] == 'Barang Di Kirim'): ?>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#terimaModal<?=$pesanan['id_pesanan']?>"
                                                data-id="<?=$pesanan['id_pesanan']?>"
                                                onclick="setTerimaModalData(this)">
                                                <i class="bx bx-check me-2"> Terima Barang</i>
                                            </a>
                                        </li>
                                        <?php elseif ($pesanan['status'] == 'Barang Diterima'): ?>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#masukModal<?=$pesanan['id_pesanan']?>"
                                                data-id="<?=$pesanan['id_pesanan']?>" onclick="setMasukModalData(this)">
                                                <i class="bx bx-move me-2"></i> Move To Barang Masuk
                                            </a>
                                        </li>
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
                                <select name="id_barang_supplier" id="id_barang_supplier" class="form-control">
                                    <option value="#">Silahkan Pilih</option>
                                    <?php foreach($barang_supplier as $barang):?>
                                    <option value="<?=$barang['id_barang_supplier'];?>"><?=$barang['nama_barang']?>
                                    </option>
                                    <?php endforeach;?>
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
        $('#id_barang_supplier').change(function() {
            const selectedId = $(this).val();
            if (selectedId) {
                // Lakukan permintaan AJAX ke controller
                $.ajax({
                    url: `<?=base_url('get-barang/');?>${selectedId}`, // Gunakan backticks dengan interpolasi
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.nama_barang && data.id_supplier && data.harga) {
                            $('#nama_barang').val(data.nama_barang);
                            $('#id_supplier').val(data.id_supplier);
                            $('#harga').val(data.harga);
                            $('#total').val('');
                        } else {
                            alert('Data tidak lengkap.');
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
    </script>
    <script>
    $(document).ready(function() {
        const tableRows = $('#data-pesanan-table tbody tr'); // Ambil semua baris tabel
        const rowsPerPage = 5; // Jumlah data per halaman
        let currentPage = 1;

        // Fungsi untuk mengonversi format tanggal MM-DD-YYYY ke YYYY-MM-DD
        function formatDate(inputDate) {
            const [year, month, day] = inputDate.split("-");
            return `${year}-${month}-${day}`;
        }

        // Fungsi untuk memfilter data
        function filterTable() {
            const searchQuery = $('#search-input').val().toLowerCase(); // Ambil input pencarian
            const selectedDate = $('#filter-date').val(); // Ambil nilai tanggal dari filter

            tableRows.hide().filter(function() {
                const rowText = $(this).text().toLowerCase(); // Seluruh teks di baris tabel
                const rowDate = $(this).find('td:nth-child(4)').text(); // Kolom tanggal masuk

                // Logika pencarian dan filter tanggal
                const matchesSearch = searchQuery === "" || rowText.includes(searchQuery);
                const matchesDate =
                    selectedDate === "" || rowDate === formatDate(selectedDate);

                return matchesSearch && matchesDate;
            }).show();

            // Reset Pagination
            paginate();
        }

        // Fungsi untuk mengatur pagination
        function paginate() {
            const visibleRows = tableRows.filter(':visible');
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage);

            $('#pagination-container').pagination({
                items: visibleRows.length,
                itemsOnPage: rowsPerPage,
                cssStyle: 'light-theme',
                onPageClick: function(pageNumber) {
                    currentPage = pageNumber;

                    const start = (currentPage - 1) * rowsPerPage;
                    const end = start + rowsPerPage;

                    visibleRows.hide().slice(start, end).show();
                }
            });

            // Tampilkan halaman pertama saat pagination direset
            visibleRows.slice(0, rowsPerPage).show();
        }

        // Fungsi untuk Print tabel
        $('#print-button').on('click', function() {
            const originalContent = document.body.innerHTML;
            const printContent = document.getElementById('data-table').outerHTML;

            document.body.innerHTML =
                `<html><head><title>Print Table</title></head><body>${printContent}</body></html>`;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // Reload untuk mengembalikan ke kondisi awal
        });

        // Fungsi untuk Download tabel sebagai CSV
        $('#download-button').on('click', function() {
            const rows = [];
            const headers = [];

            // Ambil header tabel
            $('#data-pesanan-table thead th').each(function() {
                headers.push($(this).text().trim());
            });
            rows.push(headers.join(',')); // Gabung header dengan koma

            // Ambil data baris yang terlihat
            $('#data-pesanan-table tbody tr:visible').each(function() {
                const row = [];
                $(this).find('td').each(function() {
                    row.push($(this).text().trim());
                });
                rows.push(row.join(','));
            });

            // Buat file CSV
            const csvContent = 'data:text/csv;charset=utf-8,' + rows.join('\n');
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'data_table.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Event untuk pencarian
        $('#search-input').on('input', function() {
            filterTable();
        });

        // Event untuk filter tanggal
        $('#filter-date').on('change', function() {
            filterTable();
        });

        // Inisialisasi Pagination
        paginate();
    });
    </script>
    <?=$this->endSection()?>