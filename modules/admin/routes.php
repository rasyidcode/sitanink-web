<?php

$routes->group('', ['namespace' => $routes_namespace, 'filter' => 'web-auth-filter'], function ($routes) use ($routes_namespace) {
    $routes->get('/',   'Dashboard\Controllers\DashboardController::index',     ['as' => 'admin']);
    $routes->post('/',  'Dashboard\Controllers\DashboardController::logout',    ['as' => 'admin.logout']);
    // user
    $routes->group('user', ['namespace' => $routes_namespace . 'User\Controllers\\'], function ($routes) {
        $routes->get('/',                       'UserController::index',            ['as' => 'user']);
        $routes->post('get-data',               'UserController::getData',          ['as' => 'user.get-data']);
        $routes->get('add',                     'UserController::add',              ['as' => 'user.add']);
        $routes->get('(:segment)/edit',         'UserController::edit/$1',          ['as' => 'user.edit']);
        $routes->post('(:segment)/update',      'UserController::update/$1',        ['as' => 'user.update']);
        $routes->post('create',                 'UserController::create',           ['as' => 'user.create']);
        $routes->get('(:segment)/change-pass',  'UserController::changePass/$1',    ['as' => 'user.change-pass']);
        $routes->post('(:segment)/change-pass', 'UserController::doChangePass/$1',  ['as' => 'user.do-change-pass']);
        $routes->post('(:segment)/delete',      'UserController::delete/$1',        ['as' => 'user.delete']);
    });
    // $routes->get('user/(segment)', 'User\Controllers\UserController::get/$1', ['as' => 'user.get']);

    // pekerja
    // $routes->get('pekerja', 'Pekerja\Controllers\PekerjaController::index', ['as' => 'pekerja']);
    // $routes->get('pekerja/(:segment)', 'Pekerja\Controllers\PekerjaController::get/$1', ['as' => 'pekerja.get']);
    // $routes->get('pekerja/add', 'Pekerja\Controllers\PekerjaController::add', ['as' => 'pekerja.add']);
    // $routes->get('pekerja/create', 'Pekerja\Controllers\PekerjaController::create', ['as' => 'pekerja.create']);
    // $routes->get('pekerja/(:segment)/edit', 'Pekerja\Controllers\PekerjaController::edit/$1', ['as' => 'pekerja.edit']);
    // $routes->get('pekerja/(:segment)/update', 'Pekerja\Controllers\PekerjaController::update/$1', ['as' => 'pekerja.update']);
    // $routes->get('pekerja/(:segment)/delete', 'Pekerja\Controllers\PekerjaController::delete/$1', ['as' => 'pekerja.delete']);

    // data wilayah
    // $routes->get('wilayah', 'Wilayah\Controllers\WilayahController::index', ['as' => 'wilayah']);
    // $routes->get('wilayah/detail', 'Wilayah\Controllers\WilayahController::detail', ['as' => 'wilayah.detail']);

    // notifikasi
    // $routes->get('notifikasi', 'Notifikasi\Controllers\NotifikasiControllers::index', ['as' => 'notifikasi']);
});
