<?php

namespace App\Modules\Home\Controllers;

use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
    }

    public function index()
    {
        return $this->setResponseFormat('json')->respond(
            [
                "resultCode" => 404,
                "resulrMessage" => "Not Found",
            ],
            404
        );
    }
}
