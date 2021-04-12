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
        $this->logger->writeApiLogs($request, $response, 'add_job');
        return $response;
    }

    public function allJob($request)
    {
        $response = $this->jobModel->getAllJob();
        $this->logger->writeApiLogs($request, $response, 'get_jobs');
        return $response;
    }

    public function getJobDetail($request)
    {
        $job_id = $request['payloads']['job_id'];
        $response =  $this->jobModel->getJobDetail($job_id);
        $this->logger->writeApiLogs($request, $response, 'get_job_detail');
        return $response;
    }

    public function deleteJob($request)
    {
        $token = $request['headers']['Authorization'];
        $companyId = $this->userUtils->getIdbyToken($token);
        $jobId = $request['payloads']['job_id'];
        $response =  $this->jobModel->deleteJob($companyId, $jobId);
        $this->logger->writeApiLogs($request, $response, 'delete_job');
        return $response;
    }
}
