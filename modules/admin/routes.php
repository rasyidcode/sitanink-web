<?php

$routes->group('', ['namespace' => $routes_namespace, 'filter' => 'web-auth-filter'], function ($routes) use ($routes_namespace) {
    $routes->get('/',  'Dashboard\Controllers\DashboardController::index', ['as' => 'admin']);
    $routes->post('/',  'Dashboard\Controllers\DashboardController::logout', ['as' => 'admin.logout']);
    // user
    $routes->get('user', 'User\Controllers\UserController::index', ['as' => 'user']);
    $routes->post('user/get-data', 'User\Controllers\UserController::getData', ['as' => 'user.get-data']);
    // $routes->get('user/(segment)', 'User\Controllers\UserController::get/$1', ['as' => 'user.get']);
    $routes->get('user/add', 'User\Controllers\UserController::add', ['as' => 'user.add']);
    $routes->post('user/create', 'User\Controllers\UserController::create', ['as' => 'user.create']);
    // $routes->get('user/(:segment)/edit', 'User\Controllers\UserController::edit/$1', ['as' => 'user.edit']);
    // $routes->post('user/(:segment)/update', 'User\Controllers\UserController::update/$1', ['as' => 'user.update']);
    // $routes->post('user/(:segment)/delete', 'User\Controllers\UserController::delete/$1', ['as' => 'user.delete']);
    $routes->get('user/(:segment)/reset-pass', 'User\Controllers\UserController::resetPass/$1', ['as' => 'user.reset-pass']);
    // $routes->post('user/(:segment)/reset-pass', 'User\Controllers\UserController::doResetPass/$1', ['as' => 'user.do-reset-pass']);

    // $routes->group('user', ['namespace' => $routes_namespace . 'User\Controllers\\'], function ($routes) {
    //     $routes->get('(:segment)/reset-pass', 'UserController::resetPass/$1', ['as' => 'user.reset-pass']);
    // });

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
