<?php

namespace App\Modules\Company\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Company\Repositories\CompanyRepositories;

class Company extends BaseController
{
    private $companyRepositories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->companyRepositories = new CompanyRepositories();
    }

    public function companyLogin()
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }

        return $this->setResponseFormat('json')->respond($this->companyRepositories->loginProcess($request), 200);
    }

    public function companyRegister()
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
        return $this->setResponseFormat('json')->respond($this->companyRepositories->companyRegister($request), 200);
    }

    public function companyEdit()
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
        return $this->setResponseFormat('json')->respond($this->companyRepositories->companyEdit($request), 200);
    }
}
