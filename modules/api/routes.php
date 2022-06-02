<?php

$routes->group('api/v1', ['namespace' => $routes_namespace], function ($routes) use ($routes_namespace) {
    $routes->group('user', ['namespace' => $routes_namespace . 'User\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'UserController::getData', ['as' => 'api.user.get-data']);
    });

    $routes->group('master', ['namespace' => $routes_namespace], function ($routes) use($routes_namespace) {
        $routes->group('lokasi-kerja', ['namespace' => $routes_namespace . 'Lokasikerja\Controllers\\'], function($routes) {
            $routes->post('get-data', 'LokasikerjaController::getData', ['as' => 'api.lokasi-kerja.get-data']);
        });
        $routes->group('jenis-pekerja', ['namespace' => $routes_namespace . 'Jenispekerja\Controllers\\'], function($routes) {
            $routes->post('get-data', 'JenispekerjaController::getData', ['as' => 'api.jenis-pekerja.get-data']);
        });
        $routes->group('pekerjaan', ['namespace' => $routes_namespace . 'Pekerjaan\Controllers\\'], function($routes) {
            $routes->post('get-data', 'PekerjaanController::getData', ['as' => 'api.pekerjaan.get-data']);
        });
        $routes->group('domisili', ['namespace' => $routes_namespace, 'Domisili\Controllers\\'], function($routes) {
            $routes->post('get-data', 'DomisiliController::getData', ['as' => 'api.domisili.get-data']);
        });
    });

    $routes->group('pekerja', ['namespace' => $routes_namespace . 'Pekerja\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'PekerjaController::getData', ['as' => 'api.pekerja.get-data']);
    });
});
