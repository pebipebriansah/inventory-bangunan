<?php
$this->menu_active = $this->menu_active ?? '';
$this->nav_active = $this->nav_active ?? '';
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('image/tb.png'); ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css'); ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css'); ?>"
        class="template-customizer-theme-css" />
    <!-- Include CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <!-- Include JS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/apex-charts/apex-charts.css'); ?>" />
    <script src="<?= base_url('assets/vendor/js/helpers.js'); ?>"></script>
    <script src="<?= base_url('assets/js/config.js'); ?>"></script>
    <title><?= $this->title ?? $title ?? '' ?></title>
    <meta name="description" content="" />
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <img src="<?= base_url('image/tb.png'); ?>" alt="Sneat" width="50" height="50" />
                    <span class="app-brand-text text-uppercase text-black">TB Wawan</span>
                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item <?= $this->nav_active == 'dashboard' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/'); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <!-- Layouts -->
                    <?php if (session()->get('role') == 'admin' || session()->get('role') == 'manager' || session()->get('role') == 'gudang'): ?>
                    <li class="menu-item <?= $this->menu_active == 'master' ? 'active open' : '' ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">Master Data</div>
                        </a>
                        <ul class="menu-sub">
                            <?php if (session()->get('role') == 'admin'): ?>
                            <li class="menu-item <?= $this->nav_active == 'user' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/data-user'); ?>" class="menu-link">
                                    <div data-i18n="Without menu">Data User</div>
                                </a>
                            </li>
                            <?php endif ?>
                            <?php if (session()->get('role') == 'admin' || session()->get('role') == 'Gudang'): ?>
                            <li class="menu-item <?= $this->nav_active == 'barang' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/data-barang'); ?>" class="menu-link">
                                    <div data-i18n="Without navbar">Data Barang</div>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if (session()->get('role') == 'admin'): ?>
                            <li class="menu-item <?= $this->nav_active == 'supplier' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/data-supplier'); ?>" class="menu-link">
                                    <div data-i18n="Container">Data Supplier</div>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li class="menu-item <?= $this->nav_active == 'pesanan' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/data-pesanan') ?>" class="menu-link">
                                    <div data-i18n="Fluid">Data Pesanan</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if (session()->get('role') == 'manager' || session()->get('role') == 'admin'): ?>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Laporan</span>
                    </li>
                    <li class="menu-item <?= $this->menu_active == 'laporan' ? 'active open' : '' ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">Laporan Barang</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item <?= $this->nav_active == 'barang-masuk' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/barang-masuk'); ?>" class="menu-link">
                                    <div data-i18n="Account">Barang Masuk</div>
                                </a>
                            </li>
                            <li class="menu-item <?= $this->nav_active == 'barang-keluar' ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/barang-keluar') ?>" class="menu-link">
                                    <div data-i18n="Notifications">Barang Keluar</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item <?= $this->nav_active == 'penjualan' ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/data-penjualan'); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Transaksi Penjualan</div>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/avatars/1.png" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="../assets/img/avatars/1.png" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block"><?= session()->get('nama_lengkap') ?></span>
                                                    <small class="text-muted"><?= session()->get('role'); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <?= $this->renderSection('content'); ?>
                </div>
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="text-center">
                            ©
                            <script>
                            document.write(new Date().getFullYear());
                            </script>
                            TB Wawan <small>For Company</small>
                        </div>
                    </div>
                </footer>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/js/menu.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/apex-charts/apexcharts.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>
    <script src="<?= base_url('assets/js/dashboards-analytics.js'); ?>"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <?= $this->renderSection('script'); ?>
</body>

</html>