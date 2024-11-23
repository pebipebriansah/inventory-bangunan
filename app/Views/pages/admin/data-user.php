<?php
$this->title = 'Data User';
$this->menu_active = 'master';
$this->nav_active = 'user';
$this->extend('layout/layout-admin');
$this->section('content');
?>
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
                <table id="data-user-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID User</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_pengguna)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($data_pengguna as $user): ?>
                        <tr>
                            <td><?= $user['id_user']; ?></td>
                            <td><?= $user['nama_lengkap']; ?></td>
                            <td><?= $user['username']; ?></td>
                            <td>None</td>
                            <td><?= $user['role']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#editModal<?=$user['id_user']?>"
                                                data-id="<?=$user['id_user']?>" data-user='<?= json_encode($user) ?>'
                                                onclick="setEditModalData(this)">
                                                <i class="bx bx-edit-alt me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?=$user['id_user']?>"
                                                data-id="<?=$user['id_user']?>" onclick="setDeleteModalData(this)">
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

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal<?=$user['id_user']?>" tabindex="-1" aria-labelledby="deleteModalLabel"
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
                        action="<?=base_url('admin/data-user/delete/').$user['id_user']?>">
                        <input type="hidden" id="deleteUserId" name="user_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?=$user['id_user']?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="POST" action="<?=base_url('admin/data-user/update/').$user['id_user']?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="idUser" class="form-label">ID User</label>
                            <input type="text" id="idUser" name="id_user" class="form-control" readonly />
                        </div>
                        <div class="mb-3">
                            <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="namaLengkap" name="nama_lengkap" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="gudang">Gudang</option>
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
                <form id="addOrderForm" method="POST" action="<?=base_url('admin/data-user/save')?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Enter Name" />
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

    <!-- / Content -->
    <?=$this->endSection()?>
    <?=$this->section('script')?>
    <script>
    // Function to set data for Delete Modal
    function setDeleteModalData(button) {
        const userId = button.getAttribute('data-id');
        document.getElementById('deleteUserId').value = userId;
    }

    function setEditModalData(button) {
        // Ambil data ID dari atribut data-id
        const userId = button.getAttribute('data-id');

        // Ambil data lainnya dari atribut data-user (dalam JSON)
        const userData = JSON.parse(button.getAttribute('data-user'));

        // Isi field pada modal dengan data
        document.querySelector(`#editModal${userId} #idUser`).value = userId; // dari data-id
        document.querySelector(`#editModal${userId} #namaLengkap`).value = userData.nama_lengkap;
        document.querySelector(`#editModal${userId} #username`).value = userData.username;
        document.querySelector(`#editModal${userId} #password`).value = userData.password;
        document.querySelector(`#editModal${userId} #role`).value = userData.role;
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
        const tableRows = $('#data-user-table tbody tr'); // Ambil semua baris tabel
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
            $('#data-user-table thead th').each(function() {
                headers.push($(this).text().trim());
            });
            rows.push(headers.join(',')); // Gabung header dengan koma

            // Ambil data baris yang terlihat
            $('#data-user-table tbody tr:visible').each(function() {
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