<?php

namespace App\Modules\Jobreg\Models;

use App\Entities\JobRegisEntity;
use App\Helpers\UserUtils;

class JobregModel
{
    public function __construct()
    {
        $this->JobRegisEntity = new JobRegisEntity();
        $this->userUtils = new UserUtils();
        $this->db = \Config\Database::connect();
    }

    public function addReg($data)
    {
        try {
            $checkExist = $result = $this->JobRegisEntity->where($data)->get()->getResultArray();
            $isExist = !empty($checkExist) ? true : false;
            if ($isExist) {
                $result = array(
                    'resultCode' => 400,
                    'resultMessage' => 'You have already registered',
                );
                return $result;
            } else {
                $this->JobRegisEntity->insert($data);
                $result = array(
                    'resultCode' => 201,
                    'resultMessage' => 'successfully!',
                );
                return $result;
            }
        } catch (\Exception $e) {
            $result = array(
                'resultCode' => 500,
                'resultMessage' => 'error!'
            );
            return $result;
        }
    }

    public function searchReg($condition)
    {
        $filterData = 'jobregister.jobregister_id,jobregister.created_at,job.job_id,job.job_name,job.job_description,job.salary,member.member_id,member.firstname,member.lastname,member.member_email';
        try {
            $result = $this->JobRegisEntity->where($condition)
                ->select($filterData)
                ->join('job', 'job.job_id = jobregister.job_id')
                ->join('member', 'member.member_id = jobregister.member_id')
                ->findAll();
            return [
                'resultCode' => 200,
                'resultMessage' => 'successfully!',
                'data' => $result
            ];
        } catch (\Exception $e) {
            return [
                'resultCode' => 500,
                'resultMessage' => 'error',
            ];
        }
    }
}
