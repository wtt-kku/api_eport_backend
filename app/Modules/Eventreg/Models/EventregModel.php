<?php

namespace App\Modules\Eventreg\Models;

use App\Entities\EventRegisEntity;
use App\Helpers\UserUtils;

class EventregModel
{
    public function __construct()
    {
        $this->EventRegisEntity = new EventRegisEntity();
        $this->userUtils = new UserUtils();
        $this->db = \Config\Database::connect();
    }

    public function addReg($data)
    {
        try {
            $this->EventRegisEntity->insert($data);
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
            $result = $this->EventRegisEntity->where($condition)->findAll();
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
