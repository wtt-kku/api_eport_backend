<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/member', ['namespace' => 'App\Modules\Member\Controllers'], function ($subroutes) {
    $subroutes->post('login', 'Member::memberLogin');
    $subroutes->post('register', 'Member::memberRegister');
});
