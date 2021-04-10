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
}
