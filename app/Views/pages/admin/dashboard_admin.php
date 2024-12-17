<?php
$this->title = 'Dashboard Admin';
$this->menu_active = 'dashboard';
$this->nav_active = 'dashboard';
$this->extend('layout/layout-admin');
$this->section('content');
?>
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Congratulations <?= session()->get('nama_lengkap'); ?></h5>
                    <p class="mb-4">
                        Anda Berhasil masuk menjadi <?= session()->get('role'); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Chart Data Penjualan -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Grafik Penjualan Barang</h5>
                    <div class="btn-group mb-3" role="group" aria-label="Chart Options">
                        <button type="button" class="btn btn-primary chart-option" data-type="penjualan">Grafik
                            Penjualan Barang</button>
                        <button type="button" class="btn btn-warning chart-option" data-type="stok_kosong">Grafik Stok
                            Hampir Habis</button>
                    </div>
                    <br>
                    <div style="width: 70%; margin: 0 auto;">
                        <canvas id="salesChart" style="height: 200px; width: 100%;"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentChart;

    function renderChart(canvasId, type, data, title) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        if (currentChart) {
            currentChart.destroy(); // Hapus chart lama sebelum membuat chart baru
        }

        currentChart = new Chart(ctx, {
            type: type,
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: title
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function fetchDataAndRenderChart(type) {
        let url, title;
        if (type === 'penjualan') {
            url = "<?= base_url('penjualan-terbanyak'); ?>";
            title = 'Grafik Penjualan Barang';
        } else if (type === 'stok_kosong') {
            url = "<?= base_url('stok-hampir-habis'); ?>";
            title = 'Grafik Stok Hampir Habis';
        }

        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            success: function(response) {
                let chartData;

                if (type === 'penjualan') {
                    chartData = {
                        labels: response.map(item => item.nama_barang),
                        datasets: [{
                            label: 'Total Penjualan',
                            data: response.map(item => item.stok_terjual),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    };
                } else if (type === 'stok_kosong') {
                    const stokMinimum = 50; // Batas stok minimum

                    chartData = {
                        labels: response.filter(item => item.stok < stokMinimum).map(item =>
                            item.nama_barang),
                        datasets: [{
                            label: 'Stok Sekarang',
                            data: response.filter(item => item.stok < stokMinimum).map(
                                item => item.stok),
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Stok Minimum',
                            data: response.filter(item => item.stok < stokMinimum).map(
                                () => stokMinimum),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    };
                }


                renderChart('salesChart', 'bar', chartData, title);
            },
            error: function() {
                console.error("Gagal memuat data dari " + url);
            }
        });
    }

    // Event listener untuk tombol sorting
    document.querySelectorAll('.chart-option').forEach(function(button) {
        button.addEventListener('click', function() {
            const selectedType = this.getAttribute('data-type');
            fetchDataAndRenderChart(selectedType);
        });
    });

    // Render default chart saat halaman dimuat
    fetchDataAndRenderChart('penjualan');
});
</script>

<!-- / Content -->
<?= $this->endSection() ?>