<?php

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/university', ['namespace' => 'App\Modules\University\Controllers'], function ($subroutes) {
	$subroutes->post('login', 'University::universityLogin');
	$subroutes->post('register', 'University::universityRegister');
	$subroutes->post('edit', 'University::universityEdit');
	$subroutes->post('profile', 'University::universityProfile');
});
