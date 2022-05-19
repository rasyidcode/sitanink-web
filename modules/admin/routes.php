<?php

$routes->get('/', $routes_namespace . 'Dashboard\Controllers\DashboardController::index', ['as' => 'admin']);