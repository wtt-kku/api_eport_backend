<?php

namespace App\Modules\Assets\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Assets\Repositories\AssetsRepositories;

class Assets extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->assetsRepositories = new AssetsRepositories();
    }

    public function getAllProvince()
    {
        $request = $this->apiRequest->getRequestInput($this->request);
        return $this->setResponseFormat('json')->respond($this->assetsRepositories->getAllProvince($request), 200);
    }

    public function getAmphur()
    {
        $rules = [
            "provinceID" => 'required|integer',
        ];
        $request = $this->apiRequest->getRequestInput($this->request);

        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }
        return $this->setResponseFormat('json')->respond($this->assetsRepositories->getAmphur($request), 200);
    }

    public function getCategory()
    {
        $request = $this->apiRequest->getRequestInput($this->request);
        return $this->setResponseFormat('json')->respond($this->assetsRepositories->getCategory($request), 200);
    }
}
