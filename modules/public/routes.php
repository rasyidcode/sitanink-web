<?php

$routes->get('login', $routes_namespace . 'Login\Controllers\LoginController::index', ['as' => 'login']);
$routes->post('login', $routes_namespace . 'Login\Controllers\LoginController::login', ['as' => 'do-login']);