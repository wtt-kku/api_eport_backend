<?php

namespace App\Modules\Event\Models;

use App\Entities\EventEntity;
use App\Helpers\UserUtils;

class EventModel
{
    public function __construct()
    {
        $this->eventEntity = new EventEntity();
        $this->userUtils = new UserUtils();
        $this->db = \Config\Database::connect();
    }

    public function addEvent($data)
    {

        try {
            $this->eventEntity->insert($data);
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

    public function getAllEvent()
    {
        $result = $this->eventEntity->where('status', '1')->findAll();
        return [
            'resultCode' => 200,
            'resultMessage' => 'successfully!',
            'data' => $result
        ];
    }

    public function getEventDetail($event_id)
    {
        $eventTable = $this->db->table('event');
        $query = $eventTable->select('*')
            ->where('event_id', $event_id)
            ->where('status', "1")
            ->get()->getResultArray();
        $isExist = !empty($query) ? true : false;
        if ($isExist) {
            $filterData = 'event.event_id,event.event_name,event.event_description,event.full_amount,event.regis_amount,cou.cou_id,cou.cou_name_th,event.created_at';
            $builder = $this->db->table('event');
            $builder = $builder->select($filterData);
            $builder = $builder->where('event_id', $event_id);
            $builder = $builder->join('cou', 'cou.cou_id = event.cou_id');
            $eventDeatil = $builder->get()->getResultArray();

            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'successfully!',
                'data' => $eventDeatil
            );
        } else {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'your event_id is invalid.',
            );
        }
        return $result;
    }

    public function deleteEvent($universityId, $eventId)
    {
        $condition = $this->eventEntity->select('*')
            ->where('cou_id', $universityId)
            ->where('event_id', $eventId);
        $query = $condition->get()->getResultArray();
        $isOwner = !empty($query) ? true : false;


        if (!$isOwner) {
            $result = array(
                'resultCode' => 403,
                'resultMessage' => 'Permission denied.',
            );
            return $result;
        } else {
            $this->eventEntity->select('*')
                ->where('cou_id', $universityId)
                ->where('event_id', $eventId)
                ->delete();
            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'Deleted successfully.',
            );
            return $result;
        }
    }
}
