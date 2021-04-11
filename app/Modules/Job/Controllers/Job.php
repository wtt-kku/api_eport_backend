<?php

namespace App\Modules\Job\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Job\Repositories\JobRepositories;

class Job extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->jobRepositories = new JobRepositories();
    }

    public function addJob()
    {
        $rules = [
            'category_id' => 'required|integer',
            'job_name' => 'required|string',
            'job_description' => 'required|string',
            'salary' => 'required|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }

        return $this->setResponseFormat('json')->respond($this->jobRepositories->addJob($request), 200);
    }

    public function allJob()
    {
        $request = $this->apiRequest->getRequestInput($this->request);
        return $this->setResponseFormat('json')->respond($this->jobRepositories->allJob($request), 200);
    }

    public function getJobDetail()
    {
        $rules = [
            'job_id' => 'required|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }


        return $this->setResponseFormat('json')->respond($this->jobRepositories->getJobDetail($request), 200);
    }
}
