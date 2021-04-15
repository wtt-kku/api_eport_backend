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
            $checkExist = $result = $this->EventRegisEntity->where($data)->get()->getResultArray();
            $isExist = !empty($checkExist) ? true : false;
            if ($isExist) {
                $result = array(
                    'resultCode' => 400,
                    'resultMessage' => 'You have already registered',
                );
                return $result;
            } else {
                $this->EventRegisEntity->insert($data);
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
        $filterData = 'eventregister.eventregister_id,eventregister.created_at,event.event_id,event.event_name,event.event_description,member.member_id,member.firstname,member.lastname,member.member_email';
        try {
            $result = $this->EventRegisEntity->where($condition)
                ->select($filterData)
                ->join('event', 'event.event_id = eventregister.event_id')
                ->join('member', 'member.member_id = eventregister.member_id')
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
