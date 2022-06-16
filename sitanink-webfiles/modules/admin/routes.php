<?php

$routes->group('', ['namespace' => $routes_namespace], function ($routes) use ($routes_namespace) {
    $routes->get('/',   'Dashboard\Controllers\DashboardController::index',     ['as' => 'admin']);
    $routes->post('/',  'Dashboard\Controllers\DashboardController::logout',    ['as' => 'admin.logout']);
    // master
    $routes->group('master', ['namespace' => $routes_namespace], function ($routes) use ($routes_namespace) {
        // lokasi kerja
        $routes->group('lokasi-kerja', ['namespace' => $routes_namespace . 'Lokasikerja\Controllers\\'], function ($routes) {
            $routes->get('/', 'LokasikerjaController::index', ['as' => 'lokasi-kerja']);
            $routes->get('add', 'LokasikerjaController::add', ['as' => 'lokasi-kerja.add']);
            $routes->post('create', 'LokasikerjaController::create', ['as' => 'lokasi-kerja.create']);
            $routes->get('(:segment)/edit', 'LokasikerjaController::edit/$1', ['as' => 'lokasi-kerja.edit']);
            $routes->post('(:segment)/update', 'LokasikerjaController::update/$1', ['as' => 'lokasi-kerja.update']);
            $routes->post('(:segment)/delete', 'LokasikerjaController::delete/$1', ['as' => 'lokasi-kerja.delete']);
        });
        // pekerjaan
        $routes->group('pekerjaan', ['namespace' => $routes_namespace . 'Pekerjaan\Controllers\\'], function ($routes) {
            $routes->get('/', 'PekerjaanController::index', ['as' => 'pekerjaan']);
            $routes->get('add', 'PekerjaanController::add', ['as' => 'pekerjaan.add']);
            $routes->post('create', 'PekerjaanController::create', ['as' => 'pekerjaan.create']);
            $routes->get('(:segment)/edit', 'PekerjaanController::edit/$1', ['as' => 'pekerjaan.edit']);
            $routes->post('(:segment)/update', 'PekerjaanController::update/$1', ['as' => 'pekerjaan.update']);
            $routes->post('(:segment)/delete', 'PekerjaanController::delete/$1', ['as' => 'pekerjaan.delete']);
        });
        // jenis pekerja
        $routes->group('jenis-pekerja', ['namespace' => $routes_namespace . 'Jenispekerja\Controllers\\'], function ($routes) {
            $routes->get('/', 'JenispekerjaController::index', ['as' => 'jenis-pekerja']);
            $routes->get('add', 'JenispekerjaController::add', ['as' => 'jenis-pekerja.add']);
            $routes->post('create', 'JenispekerjaController::create', ['as' => 'jenis-pekerja.create']);
            $routes->get('(:segment)/edit', 'JenispekerjaController::edit/$1', ['as' => 'jenis-pekerja.edit']);
            $routes->post('(:segment)/update', 'JenispekerjaController::update/$1', ['as' => 'jenis-pekerja.update']);
            $routes->post('(:segment)/delete', 'JenispekerjaController::delete/$1', ['as' => 'jenis-pekerja.delete']);
        });
    });
    // user
    $routes->group('user', ['namespace' => $routes_namespace . 'User\Controllers\\'], function ($routes) {
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
        $routes->get('/',           'PekerjaController::index',     ['as' => 'pekerja']);
        $routes->get('(:segment)/detail',           'PekerjaController::get/$1',     ['as' => 'pekerja.get']);
        $routes->post('get-data',   'PekerjaController::getData',   ['as' => 'pekerja.get-data']);
        $routes->get('add',         'PekerjaController::add',       ['as' => 'pekerja.add']);
        $routes->post('create',     'PekerjaController::create',    ['as' => 'pekerja.create']);
        $routes->post('createv2',     'PekerjaController::createv2',    ['as' => 'pekerja.create-v2']);
        $routes->post('(:segment)/delete', 'PekerjaController::delete/$1', ['as' => 'pekerja.delete']);
        $routes->get('(:segment)/edit', 'PekerjaController::edit/$1', ['as' => 'pekerja.edit']);
        $routes->post('(:segment)/update', 'PekerjaController::update/$1', ['as' => 'pekerja.update']);
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
    // notifikasi
    // pengaturan

    // pekerja
    // $routes->get('pekerja', 'Pekerja\Controllers\PekerjaController::index', ['as' => 'pekerja']);
    // $routes->get('pekerja/(:segment)', 'Pekerja\Controllers\PekerjaController::get/$1', ['as' => 'pekerja.get']);
    // $routes->get('pekerja/add', 'Pekerja\Controllers\PekerjaController::add', ['as' => 'pekerja.add']);
    // $routes->get('pekerja/create', 'Pekerja\Controllers\PekerjaController::create', ['as' => 'pekerja.create']);
    // $routes->get('pekerja/(:segment)/edit', 'Pekerja\Controllers\PekerjaController::edit/$1', ['as' => 'pekerja.edit']);
    // $routes->get('pekerja/(:segment)/update', 'Pekerja\Controllers\PekerjaController::update/$1', ['as' => 'pekerja.update']);
    // $routes->get('pekerja/(:segment)/delete', 'Pekerja\Controllers\PekerjaController::delete/$1', ['as' => 'pekerja.delete']);

    // data wilayah
    $routes->group('wilayah', ['namespace' => $routes_namespace . 'Wilayah\Controllers\\'], function($routes) {
        $routes->get('/', 'WilayahController::index', ['as' => 'wilayah']);
    });
    // $routes->get('wilayah/detail', 'Wilayah\Controllers\WilayahController::detail', ['as' => 'wilayah.detail']);

    // notifikasi
    // $routes->get('notifikasi', 'Notifikasi\Controllers\NotifikasiControllers::index', ['as' => 'notifikasi']);
});
