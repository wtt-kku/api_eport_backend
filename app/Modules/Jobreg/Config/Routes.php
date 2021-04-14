<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/jobreg', ['namespace' => 'App\Modules\Jobreg\Controllers'], function ($subroutes) {
    $subroutes->post('add', 'Jobreg::addreg');
    $subroutes->post('search', 'Jobreg::seachreg');
});
