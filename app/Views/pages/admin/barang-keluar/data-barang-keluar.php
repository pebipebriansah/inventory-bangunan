<?php
$this->title = 'Data Barang Keluar';
$this->menu_active = 'laporan';
$this->nav_active = 'barang-keluar';
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
    <div class="card">
        <h5 class="card-header">
            <span>Data Barang Masuk</span>
        </h5>
        <div class="card-body">
            <div class="row g-2 align-items-center mb-3">
                <div class="col-auto">
                    <select id="date_filter" class="form-control form-control-sm">
                        <option value="">Select Date Range</option>
                        <option value="all">Semua</option> <!-- Opsi "Semua" ditambahkan -->
                        <option value="today">Hari Ini</option>
                        <option value="yesterday">Kemarin</option>
                        <option value="1week">1 Minggu</option>
                        <option value="1month">1 Bulan</option>
                    </select>

                </div>
                <div class="col-auto">
                    <button id="printButton" class="btn btn-success btn-sm">Print</button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="data-barang-keluar-table" class="table hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>ID Barang Keluar</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Tanggal Keluar</th>
                        </tr>
                    </thead>
                </table>
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
        // Initialize DataTable
        let table = $('#data-barang-keluar-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/barang-keluar/get-barang-keluar') ?>',
                type: 'POST',
                data: function(d) {
                    const dateFilter = $('#date_filter').val();
                    let startDate = '';
                    let endDate = '';

                    // Set startDate and endDate based on selected filter option
                    if (dateFilter === 'today') {
                        startDate = moment().startOf('day').format('YYYY-MM-DD');
                        endDate = moment().endOf('day').format('YYYY-MM-DD');
                    } else if (dateFilter === 'yesterday') {
                        startDate = moment().subtract(1, 'days').startOf('day').format(
                            'YYYY-MM-DD');
                        endDate = moment().subtract(1, 'days').endOf('day').format('YYYY-MM-DD');
                    } else if (dateFilter === '1week') {
                        startDate = moment().subtract(1, 'weeks').startOf('day').format(
                            'YYYY-MM-DD');
                        endDate = moment().endOf('day').format('YYYY-MM-DD');
                    } else if (dateFilter === '1month') {
                        startDate = moment().subtract(1, 'months').startOf('day').format(
                            'YYYY-MM-DD');
                        endDate = moment().endOf('day').format('YYYY-MM-DD');
                    } else if (dateFilter === 'all') {
                        // Tidak ada filter tanggal untuk "Semua"
                        d.start_date = '';
                        d.end_date = '';
                    } else {
                        d.start_date = '';
                        d.end_date = '';
                    }

                    // Add the date filters to the DataTable request
                    if (startDate && endDate) {
                        d.start_date = startDate;
                        d.end_date = endDate;
                    } else {
                        d.start_date = '';
                        d.end_date = '';
                    }
                }
            },
            destroy: true
        });

        // Trigger DataTable reload whenever a date range is selected
        $('#date_filter').on('change', function() {
            table.ajax.reload();
        });

        $('#printButton').on('click', function() {
            const tableData = table.rows({
                search: 'applied'
            }).data().toArray();

            // Debugging: Periksa data yang diambil
            console.log(tableData); // Pastikan data ada

            if (tableData.length === 0) {
                alert("Tidak ada data untuk dicetak.");
                return;
            }

            let printContent = `
        <div style="text-align:center; font-family: Arial, sans-serif;">
    <!-- Kop Surat -->
    <div style="margin-bottom: 20px;">
        <!-- Logo Toko -->
        <img src="<?=base_url('image/tb.png')?>" alt="Logo" style="width: 100px; height: auto; margin-bottom: 10px;">
        <h2>TB Wawan</h2>
        <p>Jl. Kuningan No. 123, Kuningan, Indonesia</p>
        <p>Telp: +62 21 12345678 | Email: tbwawan@gmail.com</p>
    </div>

    <!-- Judul dan Filter Applied -->
    <h3>Barang Keluar Data</h3>
    <p><strong>Filter Applied: ${$('#date_filter option:selected').text()}</strong></p>

    <!-- Tabel Data -->
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; margin: 20px 0; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Barang Keluar</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal Keluar</th>
            </tr>
        </thead>
        <tbody>
            ${tableData.map(function(row, index) {
                return `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row[0] || 'N/A'}</td> <!-- id_barang_keluar -->
                        <td>${row[2] || 'N/A'}</td> <!-- nama_barang -->
                        <td>${row[3] || 'N/A'}</td> <!-- qty -->
                        <td>${row[4] || 'N/A'}</td> <!-- total -->
                        <td>${row[5] || 'N/A'}</td> <!-- tanggal_keluar -->
                    </tr>
                `;
            }).join('')}
        </tbody>
    </table>
</div>`;

            // Buka jendela print
            let printWindow = window.open('', '', 'width=800, height=600');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        });
    });
    </script>

    <?=$this->endSection()?>