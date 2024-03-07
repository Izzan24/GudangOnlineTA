<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();

/*
 * Route View 
 * Route yang digunakan untuk me-load tampilan web
 * Fungsi get(params1, params2)
 * params1 untuk url web yang dipanggil
 * params2 untuk Controller:Fungsi mana yang akan di jalankan
 */
$routes_filter = ['filter' => 'authfilter'];

$routes->get('login', 'Login::index');
$routes->get('logout', 'Login::logout');

$routes->get('/', 'Dashboard::index', $routes_filter);
$routes->get('kategori', 'Kategori::index', $routes_filter);
$routes->get('kategori/add', 'Kategori::add', $routes_filter);
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1', $routes_filter);

$routes->get('satuan', 'Satuan::index', $routes_filter);
$routes->get('satuan/add', 'Satuan::add', $routes_filter);
$routes->get('satuan/edit/(:num)', 'Satuan::edit/$1', $routes_filter);

$routes->get('barang', 'Barang::index', $routes_filter);
$routes->get('barang/add', 'Barang::add', $routes_filter);
$routes->get('barang/edit/(:any)', 'Barang::edit/$1', $routes_filter);

$routes->get('barang-masuk', 'BarangMasuk::index', $routes_filter);
$routes->get('barang-masuk/add', 'BarangMasuk::form', $routes_filter);
$routes->get('barang-masuk/add-v2', 'BarangMasuk::form_2', $routes_filter);
$routes->get('barang-masuk/print-barcode/(:any)', 'BarangMasuk::barcode/$1', $routes_filter);


$routes->get('barang-keluar', 'BarangKeluar::index', $routes_filter);
$routes->get('barang-keluar/add', 'BarangKeluar::form', $routes_filter);

$routes->get('tracking', 'Tracking::index', $routes_filter);
$routes->get('relocation', 'Relocation::index', $routes_filter);

$routes->get('stok', 'Stok::index', $routes_filter);
$routes->get('cetak-tag-rfid', 'CetakTagRfid::index', $routes_filter);

$routes->get('lokasi', 'Lokasi::index', $routes_filter);

$routes->get('user', 'User::index', $routes_filter);
$routes->get('user/add', 'User::add', $routes_filter);
$routes->get('user/edit/(:any)', 'User::edit/$1', $routes_filter);

$routes->get('page', 'Page::index', $routes_filter);

/*
 * Route API
 * Route Resource merupakan Route bawaan Codeigniter 4 
 * yang menyediakan url yang sering dibutuhkan untuk pembuatan Rest API.
 * Dokumentasi :
 * https://codeigniter4.github.io/userguide/incoming/restful.html#resource-routes
 */
$routes->resource('auth/login', ['controller' => 'Api\Auth','only' => ['create']]);

$routes->resource('api/dashboard', ['controller' => 'Api\Dashboard', 'only' => ['index']]);

$routes->resource('api/kategori', ['controller' => 'Api\Kategori']);
$routes->resource('api/satuan', ['controller' => 'Api\Satuan']);
$routes->resource('api/barang', ['controller' => 'Api\Barang']);
$routes->resource('api/barang-masuk', ['controller' => 'Api\BarangMasuk']);
$routes->resource('api/barang-masuk-detail', ['controller' => 'Api\BarangMasukDetail','only' => ['show', 'create', 'delete']]);
$routes->resource('api/barang-keluar', ['controller' => 'Api\BarangKeluar']);
$routes->resource('api/barang-keluar-detail', ['controller' => 'Api\BarangKeluarDetail','only' => ['show', 'create', 'delete']]);
$routes->resource('api/stok', ['controller' => 'Api\Stok','only' => ['index','show']]);
$routes->resource('api/lokasi', ['controller' => 'Api\Lokasi']);
$routes->resource('api/sub-lokasi', ['controller' => 'Api\SubLokasi']);
$routes->resource('api/pusher', ['controller' => 'Api\Pusher','only' => ['index','show']]);
$routes->resource('api/rfid', ['controller' => 'Api\Rfid','only' => ['index','show', 'create']]);
$routes->resource('api/tracking-barang', ['controller' => 'Api\Tracking']);
$routes->resource('api/relocation', ['controller' => 'Api\Relocation']);
$routes->resource('api/user', ['controller' => 'Api\User']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
