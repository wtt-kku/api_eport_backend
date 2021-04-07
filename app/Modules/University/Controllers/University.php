<?php

namespace App\Modules\University\Controllers;

use App\Libraries\APIRequest;
use App\Modules\University\Repositories\UniversityRepositories;

class University extends BaseController
{
    private $universityRepositories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->universityRepositories = new UniversityRepositories();
    }

    public function universityLogin()
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }

        return $this->setResponseFormat('json')->respond($this->universityRepositories->loginProcess($request), 200);
    }

    public function universityRegister()
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
            'repassword' => 'required|matches[password]',
            'email' => 'required|valid_email',
            'comnameTH' => 'required|string',
            'comnameEN' => 'required|string',
            'description' => 'string',
            'taxID' => 'required|integer',
            'phone' => 'integer',
            'address' => 'string',
            'province_id' => 'required|integer',
            'amphur_id' => 'required|integer',
        ];
        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }
        return $this->setResponseFormat('json')->respond($this->universityRepositories->universityRegister($request), 200);
    }

    public function universityEdit()
    {
        $rules = [
            'cou_id' => 'required|integer',
            'comnameTH' => 'required|string',
            'comnameEN' => 'required|string',
            'description' => 'string',
            'taxID' => 'required|integer',
            'phone' => 'integer',
            'address' => 'string',
            'province_id' => 'required|integer',
            'amphur_id' => 'required|integer',
        ];
        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }
        return $this->setResponseFormat('json')->respond($this->universityRepositories->universityEdit($request), 200);
    }

    public function universityProfile()
    {
        $rules = [
            'cou_id' => 'required|integer',
        ];
        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }
        return $this->setResponseFormat('json')->respond($this->universityRepositories->universityProfile($request), 200);
    }
}
