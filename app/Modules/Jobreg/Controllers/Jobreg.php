<?php

namespace App\Modules\Jobreg\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Jobreg\Repositories\JobregRepositories;

class Jobreg extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->jobregRepositories = new JobregRepositories();
    }


    public function addreg()
    {
        $rules = [
            'job_id' => 'required|integer',
            'member_id' => 'required|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }

        return $this->setResponseFormat('json')->respond($this->jobregRepositories->addReg($request), 200);
    }
    public function seachreg()
    {
        $request = $this->apiRequest->getRequestInput($this->request);
        return $this->setResponseFormat('json')->respond($this->jobregRepositories->searchReg($request), 200);
    }
}
