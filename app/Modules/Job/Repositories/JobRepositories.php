<?php

namespace App\Modules\Job\Repositories;

use App\Libraries\Logger;
use App\Modules\Job\Models\JobModel;
use App\Helpers\UserUtils;

use CodeIgniter\Controller;

class JobRepositories extends Controller
{
    private $jobModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->jobModel = new JobModel();
        $this->userUtils = new UserUtils();
    }

    public function addJob($request)
    {
        $token = $request['headers']['Authorization'];
        $companyId = $this->userUtils->getIdbyToken($token);
        $data = [
            'cou_id' => $companyId,
            'category_id' => $request['payloads']['category_id'],
            'job_name' => $request['payloads']['job_name'],
            'job_description' => $request['payloads']['job_description'],
            'salary' => $request['payloads']['salary'],
        ];
        $response =  $this->jobModel->addJob($data);
        $this->logger->writeApiLogs($request, $response, 'member_register');
        return $response;
    }
}
