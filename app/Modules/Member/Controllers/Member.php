<?php

namespace App\Modules\Member\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Member\Repositories\MemberRepositories;

class Member extends BaseController
{
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->MemberRepositories = new MemberRepositories();
    }

    public function memberLogin()
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }

        return $this->setResponseFormat('json')->respond($this->MemberRepositories->loginProcess($request), 200);
    }


    public function memberRegister()
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
            'repassword' => 'required|matches[password]',
            'email' => 'required|valid_email',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'idcard' => 'required|exact_length[13]|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }
        return $this->setResponseFormat('json')->respond($this->MemberRepositories->memberRegister($request), 200);
    }
}
