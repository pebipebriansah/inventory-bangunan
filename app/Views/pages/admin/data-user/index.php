<?= $this->extend('layout/layout-admin') ?>
<?= $this->section('content') ?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <?= $this->include('components/flash-messages') ?>
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Data User</span>
            <a href="<?= base_url('admin/data-user/edit/0') ?>" class="btn btn-primary ms-auto">Tambah User</a>
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
                                    <td><?= $user->id_user ?></td>
                                    <td><?= $user->nama_lengkap ?></td>
                                    <td><?= $user->username ?></td>
                                    <td>None</td>
                                    <td><?= $user->role ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-info" href="<?= base_url('admin/data-user/edit/' . $user->id_user) ?>"><i class="bx bx-edit me-2"></i></a>
                                            <a class="btn btn-sm btn-danger" href="<?= base_url('admin/data-user/delete/' . $user->id_user) ?>" onclick="return confirm('Hapus pengguna?')"><i class="bx bx-trash me-2"></i></a>
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
</div>

<!-- / Content -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
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
<?= $this->endSection() ?>