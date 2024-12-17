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
$routes->get('get-total-penjualan/(:any)','Admin\PesananController::getTotalPenjualan/$1');
$routes->get('getUserById/(:any)','Admin\UserController::getById/$1');
$routes->get('penjualan-terbanyak','Admin\PenjualanController::getPenjualanTerbanyak');
$routes->get('stok-hampir-habis','Admin\BarangController::getStokHampirHabis');
$routes->group('admin',['filter' => 'AuthFilter'], static function ($routes){
    $routes->get('/','Admin\DashboardController::index');
    //data user
    $routes->get('data-user','Admin\UserController::index');
    $routes->post('data-user/get-user','Admin\UserController::getUser');
    $routes->post('data-user/save','Admin\UserController::save');
    $routes->get('data-user/edit/(:any)','Admin\UserController::edit/$1');
    $routes->post('data-user/delete/(:any)','Admin\UserController::delete/$1');
    $routes->post('data-user/update','Admin\UserController::update');

    //barang masuk
    $routes->get('barang-masuk','Admin\BarangMasukController::index');
    $routes->post('barang-masuk/get-barang-masuk','Admin\BarangMasukController::getBarangMasuk');

    $routes->get('barang-keluar','Admin\BarangKeluarController::index');
    $routes->post('barang-keluar/get-barang-keluar','Admin\BarangKeluarController::getBarangKeluar');
    //data barang
    $routes->get('data-barang','Admin\BarangController::index');
    $routes->post('data-barang/get-barang','Admin\BarangController::getBarang');
    $routes->post('data-barang/save','Admin\BarangController::save');
    $routes->get('data-barang/edit/(:any)','Admin\BarangController::edit/$1');
    $routes->post('data-barang/delete/(:any)','Admin\BarangController::delete/$1');
    $routes->post('data-barang/update','Admin\BarangController::update');
    //data supplier
    $routes->get('data-supplier','Admin\SupplierController::index');
    $routes->post('data-supplier/get-supplier','Admin\SupplierController::getSupplier');
    $routes->post('data-supplier/save','Admin\SupplierController::save');
    $routes->get('data-supplier/edit/(:any)','Admin\SupplierController::edit/$1');
    $routes->post('data-supplier/delete/(:any)','Admin\SupplierController::delete/$1');
    $routes->post('data-supplier/update','Admin\SupplierController::update');
    //data transaksi
    $routes->get('data-pesanan','Admin\PesananController::index');
    $routes->post('data-pesanan/save','Admin\PesananController::save');
    $routes->post('data-pesanan/delete/(:any)','Admin\PesananController::delete/$1');
    $routes->post('data-pesanan/konfirmasi/(:any)','Admin\PesananController::konfirmasi/$1');
    $routes->post('data-pesanan/terima/(:any)','Admin\PesananController::terima/$1');
    $routes->post('data-pesanan/masuk/(:any)','Admin\PesananController::masuk/$1');

    // data penjualan
    $routes->get('data-penjualan','Admin\PenjualanController::index');
    $routes->post('data-penjualan/get-penjualan','Admin\PenjualanController::getPenjualan');
    $routes->post('data-penjualan/delete/(:any)','Admin\PenjualanController::delete/$1');
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