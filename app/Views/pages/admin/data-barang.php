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
                <table id="data-barang-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Supplier</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_barang)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($data_barang as $barang): ?>
                        <tr>
                            <td><?= $barang['id_barang']; ?></td>
                            <td><?= $barang['nama_barang']; ?></td>
                            <td><?= $barang['stok']; ?></td>
                            <td><?= $barang['harga']; ?></td>
                            <td><?= $barang['nama_supplier']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#editModal" data-id="<?= $barang['id_barang']; ?>"
                                                data-user='<?= json_encode($barang) ?>'
                                                onclick="setEditModalData(this)">
                                                <i class="bx bx-edit-alt me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="<?= $barang['id_barang']; ?>"
                                                onclick="setDeleteModalData(this)">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </li>
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

    <?php foreach ($data_barang as $barang) :?>
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
                    <form id="deleteForm" method="POST"
                        action="<?=base_url('admin/data-barang/delete/').$barang['id_barang']?>">
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
                <form id="editForm" method="POST"
                    action="<?=base_url('admin/data-barang/update/').$barang['id_barang']?>">
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
                            <?php foreach ($data_supplier as $supplier) :?>
                            <select id="id_supplier" name="id_supplier" class="form-control">
                                <option value="<?=$supplier['id_supplier']?>"><?=$supplier['nama_supplier']?></option>
                            </select>
                            <?php endforeach;?>
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
    <?php endforeach;?>
    <!-- Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addOrderForm" method="POST" action="<?=base_url('admin/data-barang/save')?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">ID Barang</label>
                                <input type="text" name="id_barang" readonly value="<?=$lastId?>" class="form-control"
                                    placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label class="form-label">Stok</label>
                                <input type="text" name="stok" class="form-control" placeholder="Enter Stok" />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Harga</label>
                                <input type="text" name="harga" id="dobWithTitle" class="form-control"
                                    placeholder="Contoh 150.000" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Supplier</label>
                                <?php foreach ($data_supplier as $supplier) :?>
                                <select name="id_supplier" class="form-control">
                                    <option value="#">Silahkan Pilih</option>
                                    <option value="<?=$supplier['id_supplier']?>"><?=$supplier['nama_supplier']?>
                                    </option>
                                </select>
                                <?php endforeach;?>
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
        const barangId = button.getAttribute('data-id');
        document.getElementById('deleteBarangId').value = barangId;
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
        const tableRows = $('#data-barang-table tbody tr'); // Ambil semua baris tabel
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
            $('#data-barang-table thead th').each(function() {
                headers.push($(this).text().trim());
            });
            rows.push(headers.join(',')); // Gabung header dengan koma

            // Ambil data baris yang terlihat
            $('#data-barang-table tbody tr:visible').each(function() {
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