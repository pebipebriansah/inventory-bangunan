<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('auth', 'AuthController::auth');
$routes->get('register', 'AuthController::register');
$routes->post('register/save','AuthController::save');
$routes->get('supplier','Supplier\AuthController::index');
$routes->post('supplier/auth','Supplier\AuthController::auth');
$routes->get('supplier/logout','Supplier\AuthController::logout');
$routes->get('logout','AuthController::logout');
$routes->get('get-barang/(:any)','Admin\PesananController::getBarang/$1');
$routes->get('get-barang-penjualan/(:any)','Admin\PenjualanController::getBarang/$1');
$routes->group('admin',['filter' => 'AuthFilter'], static function ($routes){
    $routes->get('/','Admin\DashboardController::index');
    //data user
    $routes->get('data-user','Admin\UserController::index');
    $routes->post('data-user/save','Admin\UserController::save');
    $routes->post('data-user/delete/(:any)','Admin\UserController::delete/$1');
    $routes->post('data-user/update/(:any)','Admin\UserController::update/$1');

    //barang masuk
    $routes->get('barang-masuk','Admin\BarangMasukController::index');
    $routes->get('barang-keluar','Admin\BarangKeluarController::index');
    //data barang
    $routes->get('data-barang','Admin\BarangController::index');
    $routes->post('data-barang/save','Admin\BarangController::save');
    $routes->post('data-barang/delete/(:any)','Admin\BarangController::delete/$1');
    $routes->post('data-barang/update/(:any)','Admin\BarangController::update/$1');
    //data supplier
    $routes->get('data-supplier','Admin\SupplierController::index');
    $routes->post('data-supplier/save','Admin\SupplierController::save');
    $routes->post('data-supplier/delete/(:any)','Admin\SupplierController::delete/$1');
    $routes->post('data-supplier/update/(:any)','Admin\SupplierController::update/$1');
    //data transaksi
    $routes->get('data-pesanan','Admin\PesananController::index');
    $routes->post('data-pesanan/save','Admin\PesananController::save');
    $routes->post('data-pesanan/delete/(:any)','Admin\PesananController::delete/$1');
    $routes->post('data-pesanan/konfirmasi/(:any)','Admin\PesananController::konfirmasi/$1');
    $routes->post('data-pesanan/terima/(:any)','Admin\PesananController::terima/$1');
    $routes->post('data-pesanan/masuk/(:any)','Admin\PesananController::masuk/$1');

    // data penjualan
    $routes->get('data-penjualan','Admin\PenjualanController::index');
    $routes->post('data-penjualan/save','Admin\PenjualanController::save');
    
    $routes->get('laporan-barang-masuk','Admin\LaporanController::indexMasuk');
    $routes->get('laporan-barang-keluar','Admin\LaporanController::indexKeluar');
    $routes->get('laporan-transaksi','Admin\LaporanController::indexTransaksi');
});
$routes->group('supplier',['filter' => 'AuthSupplierFilter'], static function ($routes){
    $routes->get('logout','Supplier\AuthController::logout');
    $routes->get('data-barang','Supplier\BarangController::index');
    $routes->post('data-barang/save','Supplier\BarangController::save');
    $routes->post('data-barang/delete/(:any)','Supplier\BarangController::delete/$1');
    $routes->post('data-barang/update/(:any)','Supplier\BarangController::update/$1');
    $routes->get('dashboard','Supplier\DashboardController::index');
    $routes->get('data-pesanan','Supplier\PesananController::index');
    $routes->post('data-pesanan/kirim/(:any)','Supplier\PesananController::kirim/$1');
});