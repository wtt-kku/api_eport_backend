<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/job', ['namespace' => 'App\Modules\Job\Controllers'], function ($subroutes) {
    // $subroutes->post('add', 'Job::addJob');
});
