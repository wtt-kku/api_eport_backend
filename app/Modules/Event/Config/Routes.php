<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/event', ['namespace' => 'App\Modules\Event\Controllers'], function ($subroutes) {
    $subroutes->post('', 'Event::allEvent');
    $subroutes->post('add', 'Event::addEvent');
    $subroutes->post('detail', 'Event::getEventDetail');
    $subroutes->post('delete', 'Event::deleteEvent');
});
