<?php

$routes->group('login', ['namespace' => $routes_namespace, 'filter' => 'web-redirect-if-auth'], function($routes) {
    $routes->get('/', 'Login\Controllers\LoginController::index', ['as' => 'login']);
    $routes->post('/', 'Login\Controllers\LoginController::login', ['as' => 'do-login']);
});
$routes->get('show-data', $routes_namespace . 'Showdata\Controllers\ShowdataController::index', ['as' => 'show-data']);