<?php

namespace App\Modules\Member\Repositories;

use App\Libraries\Logger;
use CodeIgniter\Controller;
use App\Modules\Member\Models\MemberModel;
use \Firebase\JWT\JWT;



class MemberRepositories extends Controller
{
    public function __construct()
    {
        $this->logger = new Logger();
        $this->memberModel = new MemberModel();
    }

    public function loginProcess($request)
    {
        $data = [
            'username' => $request['payloads']['username'],
            'password' => $request['payloads']['password'],
        ];
        $response = $this->memberModel->getMemberLogin($data);
        $this->logger->writeApiLogs($request, $response, 'member_login');
        return $response;
    }

    public function memberRegister($request)
    {
        $data = [
            'username' => $request['payloads']['username'],
            'password' => password_hash($request['payloads']['password'], PASSWORD_DEFAULT),
            'member_email' => $request['payloads']['email'],
            'firstname' => $request['payloads']['firstname'],
            'lastname' => $request['payloads']['lastname'],
            'idcard' => $request['payloads']['idcard'],
        ];
        $response =  $this->userModel->addMember($data);
        $this->logger->writeApiLogs($request, $response, 'userRegis');
        return $response;
    }
}
