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
            $this->JobRegisEntity->insert($data);
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

    public function searchReg($condition)
    {
        try {
            $result = $this->JobRegisEntity->where($condition)->findAll();
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
