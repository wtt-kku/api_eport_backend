<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/job', ['namespace' => 'App\Modules\Job\Controllers'], function ($subroutes) {
    $subroutes->post('', 'Job::allJob');
    $subroutes->post('add', 'Job::addJob');
    $subroutes->post('detail', 'Job::getJobDetail');
    $subroutes->post('delete', 'Job::deleteJob');
});
