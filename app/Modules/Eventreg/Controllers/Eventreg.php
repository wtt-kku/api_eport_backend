<?php

namespace App\Modules\Eventreg\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Eventreg\Repositories\EventregRepositories;

class Eventreg extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->eventregRepositories = new EventregRepositories();
    }


    public function addreg()
    {
        $rules = [
            'event_id' => 'required|integer',
            'member_id' => 'required|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }

        return $this->setResponseFormat('json')->respond($this->eventregRepositories->addReg($request), 200);
    }
    public function seachreg()
    {
        $request = $this->apiRequest->getRequestInput($this->request);
        return $this->setResponseFormat('json')->respond($this->eventregRepositories->searchReg($request), 200);
    }
}
