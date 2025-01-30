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
    $(document).ready(function() {
        let ctx = document.getElementById("salesChart").getContext("2d");
        let salesChart;

        function loadChart(chartType) {
            $.ajax({
                url: "<?= base_url('get_chart_data'); ?>",
                type: "GET",
                data: { type: chartType },
                dataType: "json",
                success: function(response) {
                    if (salesChart) {
                        salesChart.destroy();
                    }

                    salesChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: chartType === "penjualan" ? "Penjualan Barang" : "Stok Hampir Habis",
                                data: response.data,
                                backgroundColor: chartType === "penjualan" ? "rgba(54, 162, 235, 0.5)" : "rgba(255, 165, 0, 0.5)",
                                borderColor: chartType === "penjualan" ? "rgba(54, 162, 235, 1)" : "rgba(255, 165, 0, 1)",
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
        }

        $(".chart-option").click(function() {
            let type = $(this).data("type");
            loadChart(type);
        });

        loadChart("penjualan");
    });
</script>
<!-- / Content -->
<?= $this->endSection() ?>