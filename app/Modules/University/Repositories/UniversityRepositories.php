<?php

namespace App\Modules\University\Repositories;

use App\Libraries\Logger;
use App\Modules\University\Models\UniversityModel;
use CodeIgniter\Controller;
use App\Helpers\UserUtils;

class UniversityRepositories extends Controller
{
    private $universityModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->universityModel = new UniversityModel();
        $this->userUtils = new UserUtils();
    }

    public function loginProcess($request)
    {
        $data = [
            'username' => $request['payloads']['username'],
            'password' => $request['payloads']['password'],
        ];
        $response = $this->universityModel->getUniversityLogin($data);
        $this->logger->writeApiLogs($request, $response, 'university_login');
        return $response;
    }

    public function universityRegister($request)
    {
        $data = [
            'cou_type' => '1',
            'cou_username' => $request['payloads']['username'],
            'cou_password' => password_hash($request['payloads']['password'], PASSWORD_DEFAULT),
            'cou_email' => $request['payloads']['email'],
            'cou_name_th' => $request['payloads']['comnameTH'],
            'cou_name_en' => $request['payloads']['comnameEN'],
            'cou_description' => $request['payloads']['description'],
            'cou_tax_id' => $request['payloads']['taxID'],
            'phone' => $request['payloads']['phone'],
            'address' => $request['payloads']['address'],
            'province_id' => $request['payloads']['province_id'],
            'amphur_id' => $request['payloads']['amphur_id'],
        ];
        $response =  $this->universityModel->addUniversity($data);
        $this->logger->writeApiLogs($request, $response, 'university_register');
        return $response;
    }

    public function universityEdit($request)
    {
        $token = $request['headers']['Authorization'];
        $cou_id = $request['payloads']['cou_id'];
        $permission = $this->userUtils->checkPermission($token, $cou_id, "university");
        if ($permission) {

            $data = [
                'cou_name_th' => $request['payloads']['comnameTH'],
                'cou_name_en' => $request['payloads']['comnameEN'],
                'cou_description' => $request['payloads']['description'],
                'cou_tax_id' => $request['payloads']['taxID'],
                'phone' => $request['payloads']['phone'],
                'address' => $request['payloads']['address'],
                'amphur_id' => $request['payloads']['amphur_id'],
                'province_id' => $request['payloads']['province_id'],
            ];

            $response =  $this->universityModel->editUniversity($cou_id, $data);
        } else {
            $response = [
                'resultCode' => 403,
                'resultMessage' => 'Permission denied.',
            ];
        }
        $this->logger->writeApiLogs($request, $response, 'university_edit');
        return $response;
    }


    public function universityProfile($request)
    {
        $cou_id = $request['payloads']['cou_id'];
        $response =  $this->universityModel->universityProfile($cou_id);
        $this->logger->writeApiLogs($request, $response, 'university_profile');
        return $response;
    }
}
