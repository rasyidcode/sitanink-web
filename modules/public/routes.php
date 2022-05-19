<?php

$routes->group('login', ['namespace' => $routes_namespace, 'filter' => 'web-redirect-if-auth'], function($routes) {
    $routes->get('/', 'Login\Controllers\LoginController::index', ['as' => 'login']);
    $routes->post('/', 'Login\Controllers\LoginController::login', ['as' => 'do-login']);
});