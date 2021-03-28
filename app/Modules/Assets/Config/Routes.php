<?php

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/assets', ['namespace' => 'App\Modules\Assets\Controllers'], function ($subroutes) {
	$subroutes->post('province', 'Assets::getAllProvince');
	$subroutes->post('amphur', 'Assets::getAmphur');
	$subroutes->post('category', 'Assets::getCategory');
});
