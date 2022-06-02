<?php

$routes->group('api/v1', ['namespace' => $routes_namespace], function ($routes) use ($routes_namespace) {
    $routes->group('user', ['namespace' => $routes_namespace . 'User\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'UserController::getData', ['as' => 'api.user.get-data']);
    });

    $routes->group('pekerja', ['namespace' => $routes_namespace . 'Pekerja\Controllers\\'], function ($routes) {
        $routes->post('get-data', 'PekerjaController::getData', ['as' => 'api.pekerja.get-data']);
    });
});
