<?php

namespace App\Modules\Job\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class BaseController extends Controller
{
    use ResponseTrait;
    protected $helpers = [];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
}
