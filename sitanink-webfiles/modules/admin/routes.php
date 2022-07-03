<?php

$routes->group('', ['namespace' => $routes_namespace], function ($routes) use ($routes_namespace) {
    $routes->get('/',   'Dashboard\Controllers\DashboardController::index',                 ['as' => 'admin']);
    $routes->post('/',  'Dashboard\Controllers\DashboardController::logout',                ['as' => 'admin.logout']);
    $routes->get('/not-allowed',  'Dashboard\Controllers\DashboardController::notAllowed',     ['as' => 'admin.not-allowed']);

    // lokasi kerja
    $routes->group('lokasi-kerja', ['namespace' => $routes_namespace . 'Lokasikerja\Controllers\\', 'filter' => 'only-admin-filter'], function ($routes) {
        $routes->get('/', 'LokasikerjaController::index', ['as' => 'lokasi-kerja']);
        $routes->get('add', 'LokasikerjaController::add', ['as' => 'lokasi-kerja.add']);
        $routes->post('create', 'LokasikerjaController::create', ['as' => 'lokasi-kerja.create']);
        $routes->get('(:segment)/edit', 'LokasikerjaController::edit/$1', ['as' => 'lokasi-kerja.edit']);
        $routes->post('(:segment)/update', 'LokasikerjaController::update/$1', ['as' => 'lokasi-kerja.update']);
        $routes->post('(:segment)/delete', 'LokasikerjaController::delete/$1', ['as' => 'lokasi-kerja.delete']);
    });
    // jenis pekerja
    $routes->group('jenis-pekerja', ['namespace' => $routes_namespace . 'Jenispekerja\Controllers\\', 'filter' => 'only-admin-filter'], function ($routes) {
        $routes->get('/', 'JenispekerjaController::index', ['as' => 'jenis-pekerja']);
        $routes->get('add', 'JenispekerjaController::add', ['as' => 'jenis-pekerja.add']);
        $routes->post('create', 'JenispekerjaController::create', ['as' => 'jenis-pekerja.create']);
        $routes->get('(:segment)/edit', 'JenispekerjaController::edit/$1', ['as' => 'jenis-pekerja.edit']);
        $routes->post('(:segment)/update', 'JenispekerjaController::update/$1', ['as' => 'jenis-pekerja.update']);
        $routes->post('(:segment)/delete', 'JenispekerjaController::delete/$1', ['as' => 'jenis-pekerja.delete']);
    });
    // tipe berkas
    $routes->group('tipe-berkas', ['namespace' => $routes_namespace . 'Berkastype\Controllers\\', 'filter' => 'only-admin-filter'], function ($routes) {
        $routes->get('/', 'BerkastypeController::index', ['as' => 'tipe-berkas']);
        $routes->get('add', 'BerkastypeController::add', ['as' => 'tipe-berkas.add']);
        $routes->post('create', 'BerkastypeController::create', ['as' => 'tipe-berkas.create']);
        $routes->get('(:segment)/edit', 'BerkastypeController::edit/$1', ['as' => 'tipe-berkas.edit']);
        $routes->post('(:segment)/update', 'BerkastypeController::update/$1', ['as' => 'tipe-berkas.update']);
        $routes->post('(:segment)/delete', 'BerkastypeController::delete/$1', ['as' => 'tipe-berkas.delete']);
    });
    // user
    $routes->group('user', ['namespace' => $routes_namespace . 'User\Controllers\\', 'filter' => 'only-admin-filter'], function ($routes) {
        $routes->get('/',                       'UserController::index',            ['as' => 'user']);
        $routes->get('add',                     'UserController::add',              ['as' => 'user.add']);
        $routes->post('create',                 'UserController::create',           ['as' => 'user.create']);
        $routes->get('(:segment)/edit',         'UserController::edit/$1',          ['as' => 'user.edit']);
        $routes->post('(:segment)/update',      'UserController::update/$1',        ['as' => 'user.update']);
        $routes->get('(:segment)/change-pass',  'UserController::changePass/$1',    ['as' => 'user.change-pass']);
        $routes->post('(:segment)/change-pass', 'UserController::doChangePass/$1',  ['as' => 'user.do-change-pass']);
        $routes->post('(:segment)/delete',      'UserController::delete/$1',        ['as' => 'user.delete']);
    });
    // pekerja
    $routes->group('pekerja', ['namespace' => $routes_namespace . 'Pekerja\Controllers\\'], function ($routes) {
        $routes->get('/',                   'PekerjaController::index',         ['as' => 'pekerja']);
        $routes->get('(:segment)/detail',   'PekerjaController::get/$1',        ['as' => 'pekerja.get']);
        $routes->post('get-data',           'PekerjaController::getData',       ['as' => 'pekerja.get-data']);
        $routes->get('add',                 'PekerjaController::add',           ['as' => 'pekerja.add']);
        $routes->post('create',             'PekerjaController::create',        ['as' => 'pekerja.create']);
        $routes->post('(:segment)/delete',  'PekerjaController::delete/$1',     ['as' => 'pekerja.delete']);
        $routes->get('(:segment)/edit',     'PekerjaController::edit/$1',       ['as' => 'pekerja.edit']);
        $routes->post('(:segment)/update',  'PekerjaController::update/$1',     ['as' => 'pekerja.update']);
        $routes->get('export',              'PekerjaController::export',        ['as' => 'pekerja.export']);
        $routes->post('import',             'PekerjaController::import',        ['as' => 'pekerja.import']);
    });
    // review
    $routes->group('review', ['namespace' => $routes_namespace . 'Review\Controllers\\'], function ($routes) {
        $routes->get('/',      'ReviewController::index',      ['as' => 'review']);
        $routes->get('(:segment)/confirm',   'ReviewController::confirm/$1',    ['as' => 'review.confirm']);
        $routes->post('(:segment)/confirm', 'ReviewController::doConfirm/$1', ['as' => 'review.do-confirm']);
        $routes->post('(:segment)/cancel', 'ReviewController::cancel/$1', ['as' => 'review.cancel']);
    });
    // input data
    $routes->group('input-data', ['namespace' => $routes_namespace . 'Inputdata\Controllers\\'], function ($routes) {
        $routes->get('/', 'InputDataController::index', ['as' => 'input-data']);
    });
    // data wilayah
    $routes->group('wilayah', ['namespace' => $routes_namespace . 'Wilayah\Controllers\\'], function($routes) {
        $routes->get('/', 'WilayahController::index', ['as' => 'wilayah']);
        $routes->get('download/excel', 'WilayahController::downloadExcel', ['as' => 'wilayah.download-excel']);
    });
    // data qrcode
    $routes->group('qrcode', ['namespace' => $routes_namespace . 'Qrcode\Controllers\\', 'filter' => 'only-admin-filter'], function($routes) {
        $routes->get('/', 'QrcodeController::index', ['as' => 'qrcode']);
    });
    // data sk
    $routes->group('sk', ['namespace' => $routes_namespace . 'Sk\Controllers\\'], function($routes) {
        $routes->get('/',                   'SkController::index',          ['as' => 'sk']);
        $routes->get('create',              'SkController::create',         ['as' => 'sk.create']);
        $routes->post('create',             'SkController::doCreate',       ['as' => 'sk.do-create']);
        $routes->get('dowload/(:segment)',  'SkController::download/$1',    ['as' => 'sk.download']);
        $routes->get('show/(:segment)',     'SkController::show/$1',        ['as' => 'sk.show']);
        $routes->post('(:segment)/delete',  'SkController::delete/$1',      ['as' => 'sk.delete']);
    });
    // data kartu
    $routes->group('kartu2', ['namespace' => $routes_namespace . 'Kartu\Controllers\\'], function($routes) {
        $routes->get('list', 'KartuController::index', ['as' => 'kartu']);        
        $routes->get('generate', 'KartuController::generate', ['as' => 'kartu.generate']);
        $routes->post('(:segment)/delete', 'KartuController::delete/$1', ['as' => 'kartu.delete']);
    });
    // pengaturan
    $routes->group('setting', ['namespace' => $routes_namespace . 'Setting\Controllers\\'], function($routes) {
        $routes->get('/', 'SettingController::index', ['as' => 'setting']);
        $routes->post('/', 'SettingController::create', ['as' => 'setting.create']);
    });
    // notifikasi
    $routes->get('notifikasi', 'Notifikasi\Controllers\NotifikasiController::index', ['as' => 'notifikasi']);
    // dokumentasi
    $routes->get('dokumentasi', 'Dokumentasi\Controllers\DokumentasiController::index', ['as' => 'dokumentasi']);
});
