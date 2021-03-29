<?php

namespace App\Modules\Member\Repositories;

use App\Libraries\Logger;
use CodeIgniter\Controller;
use App\Modules\Member\Models\MemberModel;
use App\Helpers\UserUtils;



class MemberRepositories extends Controller
{
    public function __construct()
    {
        $this->logger = new Logger();
        $this->memberModel = new MemberModel();
        $this->userUtils = new UserUtils();
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
        $response =  $this->memberModel->addMember($data);
        $this->logger->writeApiLogs($request, $response, 'member_register');
        return $response;
    }

    public function memberEdit($request)
    {
        $token = $request['headers']['Authorization'];
        $checkType = $this->userUtils->jwtDecodeCheckAccType($token, "member");
        if ($checkType) {
            $member_id = $request['payloads']['member_id'];
            $data = [
                'member_email' =>  $request['payloads']['email'],
                'firstname' =>  $request['payloads']['firstname'],
                'lastname' =>  $request['payloads']['lastname'],
            ];
            $response =  $this->memberModel->editMember($member_id, $data);
        } else {
            $response = [
                'resultCode' => 403,
                'resultMessage' => 'your account must be member.',
            ];
        }
        $this->logger->writeApiLogs($request, $response, 'member_edit');
        return $response;
    }

    public function memberPrfoile($request)
    {
        $member_id = $request['payloads']['member_id'];
        $response =  $this->memberModel->memberPrfoile($member_id);
        $this->logger->writeApiLogs($request, $response, 'member_edit');
        return $response;
    }
}
