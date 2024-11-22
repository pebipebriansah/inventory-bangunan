<?= $this->extend('layout/layout-admin') ?>
<?= $this->section('content') ?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <?= $this->include('components/flash-messages') ?>
    <!-- Tabel Data Barang -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data Barang</span>
            <button type="button" id="add-button" class="btn btn-primary ms-auto">
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
    <!-- / Content -->

    <?= $this->include('pages/admin/barang/editor') ?>
    <?= $this->include('pages/admin/barang/delete') ?>
    <?= $this->endSection() ?>

    <?= $this->section('script') ?>
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
            // Handle add barang
            $('#add-button').click(() => {
                $('#editor-label').text('Tambah Barang')
                $('#editor').modal('show')
                $('#editor-form').attr('action', '<?= base_url('admin/data-barang/save') ?>');
            });

            // Handle edit barang
            $('.edit-button').click(() => {
                let id = 0; // TODO: get id dari tabel
                $('#editor-label').text('Edit Barang')
                $('#editor').modal('show')
                $('#editor-form').attr('action',  '<?= base_url('admin/data-barang/update' + id) ?>');
            });

            // Handle delete barang
            $('.delete-button').click(() => {
                alert('handle delete')
            });

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
    <?= $this->endSection() ?>