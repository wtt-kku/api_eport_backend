<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/eventreg', ['namespace' => 'App\Modules\Eventreg\Controllers'], function ($subroutes) {
    $subroutes->post('add', 'Eventreg::addreg');
    $subroutes->post('search', 'Eventreg::seachreg');
});
