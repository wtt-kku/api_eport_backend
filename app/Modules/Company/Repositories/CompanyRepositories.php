<?php

namespace App\Modules\Company\Repositories;

use App\Libraries\Logger;
use App\Modules\Company\Models\CompanyModel;
use CodeIgniter\Controller;
use App\Helpers\UserUtils;

class CompanyRepositories extends Controller
{
    private $companyModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->companyModel = new CompanyModel();
        $this->userUtils = new UserUtils();
    }

    public function loginProcess($request)
    {
        $data = [
            'username' => $request['payloads']['username'],
            'password' => $request['payloads']['password'],
        ];
        $response = $this->companyModel->getCompanyLogin($data);
        $this->logger->writeApiLogs($request, $response, 'company_login');
        return $response;
    }

    public function companyRegister($request)
    {
        $data = [
            'cou_type' => '0',
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
        $response =  $this->companyModel->addCompany($data);
        $this->logger->writeApiLogs($request, $response, 'company_register');
        return $response;
    }
}
