<?php

namespace App\Modules\Job\Models;

use App\Entities\JobEntity;
use App\Helpers\UserUtils;

class JobModel
{
    public function __construct()
    {
        $this->jobEntity = new JobEntity();
        $this->userUtils = new UserUtils();
        $this->db = \Config\Database::connect();
    }

    public function addJob($data)
    {
        $cateTable = $this->db->table('category');
        $query = $cateTable->select('*')
            ->where('category_id', $data['category_id'])
            ->get()->getResultArray();
        $isExistCate = !empty($query) ? true : false;

        if (!$isExistCate) {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'Category Invalid',
            );
            return $result;
        }

        try {
            $this->jobEntity->insert($data);
            $result = array(
                'resultCode' => 201,
                'resultMessage' => 'successfully!',
            );
            return $result;
        } catch (\Exception $e) {
            $result = array(
                'resultCode' => 500,
                'resultMessage' => 'error!'
            );
            return $result;
        }
    }

    public function getAllJob()
    {
        $result = $this->jobEntity->where('status', '1')->findAll();
        return [
            'resultCode' => 200,
            'resultMessage' => 'successfully!',
            'data' => $result
        ];
    }

    public function getJobDetail($job_id)
    {
        $jobTable = $this->db->table('job');
        $query = $jobTable->select('*')
            ->where('job_id', $job_id)
            ->where('status', "1")
            ->get()->getResultArray();
        $isExist = !empty($query) ? true : false;
        if ($isExist) {
            $filterData = 'job.job_id,category.category_name,job.job_name,job.job_description,job.salary,cou.cou_id,cou.cou_name_th,job.created_at';
            $builder = $this->db->table('job');
            $builder = $builder->select($filterData);
            $builder = $builder->where('job_id', $job_id);
            $builder = $builder->join('category', 'category.category_id  = job.category_id');
            $builder = $builder->join('cou', 'cou.cou_id = job.cou_id');
            $jobDeatil = $builder->get()->getResultArray();

            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'successfully!',
                'data' => $jobDeatil
            );
        } else {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'your job_id is invalid.',
            );
        }
        return $result;
    }

    public function deleteJob($companyId, $jobId)
    {
        $condition = $this->jobEntity->select('*')
            ->where('cou_id', $companyId)
            ->where('job_id', $jobId);
        $query = $condition->get()->getResultArray();
        $isOwner = !empty($query) ? true : false;

        if (!$isOwner) {
            $result = array(
                'resultCode' => 403,
                'resultMessage' => 'Permission denied.',
            );
            return $result;
        } else {
            $this->jobEntity->select('*')
                ->where('cou_id', $companyId)
                ->where('job_id', $jobId)
                ->delete();
            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'Deleted successfully.',
            );
            return $result;
        }
    }
}
