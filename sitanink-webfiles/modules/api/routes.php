<?php

$routes->group('api/v1', ['namespace' => $routes_namespace], function ($routes) use ($routes_namespace) {
    $routes->group('user', ['namespace' => $routes_namespace . 'User\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'UserController::getData', ['as' => 'api.user.get-data']);
    });

    $routes->group('master', ['namespace' => $routes_namespace], function ($routes) use ($routes_namespace) {
        $routes->group('lokasi-kerja', ['namespace' => $routes_namespace . 'Lokasikerja\Controllers\\'], function ($routes) {
            $routes->post('get-data', 'LokasikerjaController::getData', ['as' => 'api.lokasi-kerja.get-data']);
        });
        $routes->group('jenis-pekerja', ['namespace' => $routes_namespace . 'Jenispekerja\Controllers\\'], function ($routes) {
            $routes->post('get-data', 'JenispekerjaController::getData', ['as' => 'api.jenis-pekerja.get-data']);
        });
        $routes->group('tipe-berkas', ['namespace' => $routes_namespace . 'Berkastype\Controllers\\'], function ($routes) {
            $routes->post('get-data', 'BerkastypeController::getData', ['as' => 'api.tipe-berkas.get-data']);
        });
    });

    $routes->group('pekerja', ['namespace' => $routes_namespace . 'Pekerja\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'PekerjaController::getData', ['as' => 'api.pekerja.get-data']);
        $routes->post('(:segment)/delete', 'PekerjaController::delete/$1', ['as' => 'api.pekerja.delete']);
    });

    $routes->group('wilayah', ['namespace' => $routes_namespace . 'Wilayah\Controllers\\'], function ($routes) {
        $routes->get('(:segment)/pekerja', 'WilayahController::getListPekerja/$1', ['as' => 'api.wilayah.list-pekerja']);
        $routes->post('get-data', 'WilayahController::getData', ['as' => 'api.wilayah.get-data']);
    });

    $routes->group('qrcode', ['namespace' => $routes_namespace . 'Qrcode\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'QrcodeController::getData', ['as' => 'api.qrcode.get-data']);
        $routes->post('(:segment)/generate', 'QrcodeController::generate/$1', ['as' => 'qrcode.generate']);
    });

    $routes->group('card', ['namespace' => $routes_namespace . 'Card\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'CardController::getData', ['as' => 'api.card.get-data']);
        $routes->get('get-berkas/(:segment)', 'CardController::getCard/$1', ['as' => 'api.card.get-berkas']);
        $routes->post('generate', 'CardController::generate', ['as' => 'api.card.generate']);
        $routes->post('(:segment)/print', 'CardController::print/$1', ['as' => 'api.card.print']);
        $routes->post('test-backcard', 'CardController::testGenerateBackCard', ['as' => 'api.card.test-backcard']);
    });

    $routes->group('sk', ['namespace' => $routes_namespace . 'Sk\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'SkController::getData', ['as' => 'api.sk.get-data']);
    });

    $routes->group('berkas', ['namespace' => $routes_namespace . 'Berkas\Controllers\\'], function ($routes) {
        $routes->get('get-by-pekerja-and-type/(:segment)/(:segment)',       'BerkasController::getByPekerjaAndType/$1/$2',      ['as' => 'api.berkas.get-by-pekerja-and-type']);
        $routes->post('delete-by-pekerja-and-type/(:segment)(:segment)',    'BerkasController::deleteByPekerjaAndType/$1/$2',   ['as' => 'api.berkas.delete-by-pekerja-and-type']);
    });
});
