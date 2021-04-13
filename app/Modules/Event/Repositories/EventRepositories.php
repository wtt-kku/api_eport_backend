<?php

namespace App\Modules\Event\Repositories;

use App\Libraries\Logger;
use App\Modules\Event\Models\EventModel;
use App\Helpers\UserUtils;

use CodeIgniter\Controller;

class EventRepositories extends Controller
{
    private $eventModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->eventModel = new EventModel();
        $this->userUtils = new UserUtils();
    }

    public function addEvent($request)
    {
        $token = $request['headers']['Authorization'];
        $universityId = $this->userUtils->getIdbyToken($token);
        $data = [
            'cou_id' => $universityId,
            'event_name' => $request['payloads']['event_name'],
            'event_description' => $request['payloads']['event_description'],
            'full_amount' => $request['payloads']['full_amount'],

        ];
        $response =  $this->eventModel->addEvent($data);
        $this->logger->writeApiLogs($request, $response, 'add_event');
        return $response;
    }

    public function allEvent($request)
    {
        $response = $this->eventModel->getAllEvent();
        $this->logger->writeApiLogs($request, $response, 'get_events');
        return $response;
    }

    public function getEventDetail($request)
    {
        $event_id = $request['payloads']['event_id'];
        $response =  $this->eventModel->getEventDetail($event_id);
        $this->logger->writeApiLogs($request, $response, 'get_event_detail');
        return $response;
    }

    public function deleteEvent($request)
    {
        $token = $request['headers']['Authorization'];
        $universityId = $this->userUtils->getIdbyToken($token);
        $eventId = $request['payloads']['event_id'];
        $response =  $this->eventModel->deleteEvent($universityId, $eventId);
        $this->logger->writeApiLogs($request, $response, 'delete_event');
        return $response;
    }
}
