<?php

namespace App\Modules\Assets\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class BaseController extends Controller
{
    use ResponseTrait;
    protected $helpers = [];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
    }
}
