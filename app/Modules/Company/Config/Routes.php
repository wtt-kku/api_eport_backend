<?php

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group(API_PATH . '/company', ['namespace' => 'App\Modules\Company\Controllers'], function ($subroutes) {
	$subroutes->post('login', 'Company::companyLogin');
	$subroutes->post('register', 'Company::companyRegister');
	$subroutes->post('edit', 'Company::companyEdit');
	$subroutes->post('profile', 'Company::companyProfile');
});
