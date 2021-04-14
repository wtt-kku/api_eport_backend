<?php

namespace App\Modules\Jobreg\Repositories;

use App\Libraries\Logger;
use App\Modules\Jobreg\Models\JobregModel;
use App\Helpers\UserUtils;

use CodeIgniter\Controller;

class JobregRepositories extends Controller
{
    private $jobregModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->jobregModel = new JobregModel();
        $this->userUtils = new UserUtils();
    }

    public function addReg($request)
    {
        $token = $request['headers']['Authorization'];
        $member_id = $request['payloads']['member_id'];
        $permission = $this->userUtils->checkPermission($token, $member_id, "member");
        if ($permission) {
            $data = [
                'member_id' => $request['payloads']['member_id'],
                'job_id' => $request['payloads']['job_id'],
            ];
            $response =  $this->jobregModel->addReg($data);
        } else {
            $response = [
                'resultCode' => 403,
                'resultMessage' => 'Permission denied.',
            ];
        }
        $this->logger->writeApiLogs($request, $response, 'add_job_register');
        return $response;
    }

    public function searchReg($request)
    {
        $condition = [];
        (isset($request['payloads']['member_id']) && $request['payloads']['member_id']) ? $condition["member_id"] = $request['payloads']['member_id'] : false;
        (isset($request['payloads']['job_id']) && $request['payloads']['job_id']) ? $condition["job_id"] = $request['payloads']['job_id'] : false;
        $response =  $this->jobregModel->searchReg($condition);
        $this->logger->writeApiLogs($request, $response, 'search_job_register');
        return $response;
    }
}
