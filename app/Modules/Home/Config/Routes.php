<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/home', ['namespace' => 'App\Modules\Home\Controllers'], function ($subroutes) {
    $subroutes->add('', 'Home::index');
});