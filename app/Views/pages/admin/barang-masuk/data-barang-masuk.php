<?php
$this->title = 'Data Barang Masuk';
$this->menu_active = 'laporan';
$this->nav_active = 'barang-masuk';
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
                <table id="data-barang-masuk-table" class="table hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Total</th>
                            <th>Stok</th>
                            <th>Supplier</th>
                            <th>Tanggal Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="mt-3">
                <p style="text-align: justify;"><strong>Catatan:</strong> <br>Data yang ditampilkan dalam tabel ini menggunakan metode <em>First In,
                        First Out</em> (FIFO).
                    Metode ini merekomendasikan pengeluaran barang berdasarkan urutan masuknya, yaitu barang yang lebih
                    dulu masuk
                    akan didahulukan untuk dikeluarkan. Hal ini bertujuan untuk menjaga kualitas barang serta
                    menghindari risiko
                    barang kadaluarsa atau mengalami penurunan kualitas akibat penyimpanan terlalu lama.</p>
            </div>

        </div>
    </div>
    <div class="modal fade" id="keluarkanModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Keluarkan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="keluarkanForm" method="POST">
                        <input type="hidden" id="keluarBarangId" name="barang_id">
                        <input type="text" id="jumlah" name="jumlah" class="form-control">
                        <br>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Keluarkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->
    <?= $this->endSection() ?>
    <?= $this->section('script') ?>
    <script>
    $(document).ready(function() {
        // Initialize DataTable
        let table = $('#data-barang-masuk-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/barang-masuk/get-barang-masuk') ?>',
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
    <h3>Data Barang Masuk</h3>
    <p><strong>Filter Applied: ${$('#date_filter option:selected').text()}</strong></p>

    <!-- Tabel Data -->
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; margin: 20px 0; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Barang Masuk</th>
                <th>Nama Barang</th>
                <th>Total</th>
                <th>Supplier</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            ${tableData.map(function(row, index) {
                return `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${row[1] || 'N/A'}</td> 
                        <td>${row[2] || 'N/A'}</td> 
                        <td>${row[3] || 'N/A'}</td>
                        <td>${row[4] || 'N/A'}</td> 
                        <td>${row[5] || 'N/A'}</td> 
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
    <script>
    $(document).on('submit', '#keluarkanForm', function(e) {
        e.preventDefault(); // Mencegah pengiriman form default

        var jumlah = $('#jumlah').val();
        if (isNaN(jumlah) || jumlah <= 0) {
            showToast('Error', 'Jumlah barang yang dikeluarkan tidak valid.');
            return;
        }

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            dataType: 'json', // Pastikan respons diproses sebagai JSON
            success: function(response) {
                console.log("Response dari server:", response); // Debugging

                if (response.status === 'success') {
                    showToast('success', response.message);
                    $('#keluarkanModal').modal('hide');
                    $('#data-barang-masuk-table').DataTable().ajax.reload();
                } else {
                    showToast('error', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText); // Debugging error
                showToast('error', 'Terjadi kesalahan dalam mengeluarkan barang!');
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#keluarkanModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var userId = button.data('user-id') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('.modal-header').text('Apakah Anda yakin ingin mengeluarkan barang dengan ID ' +
                userId + '?')
            modal.find('form').attr('action', 'barang-masuk/keluar/' + userId);
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
    <?= $this->endSection() ?>