<?php

namespace App\Modules\Event\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Event\Repositories\EventRepositories;

class Event extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->eventRepositories = new EventRepositories();
    }

    public function addEvent()
    {
        $rules = [
            'event_name' => 'required|string',
            'event_description' => 'required|string',
            'full_amount' => 'required|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }

        return $this->setResponseFormat('json')->respond($this->eventRepositories->addEvent($request), 200);
    }

    public function allEvent()
    {
        $request = $this->apiRequest->getRequestInput($this->request);
        return $this->setResponseFormat('json')->respond($this->eventRepositories->allEvent($request), 200);
    }

    public function getEventDetail()
    {
        $rules = [
            'event_id' => 'required|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }


        return $this->setResponseFormat('json')->respond($this->eventRepositories->getEventDetail($request), 200);
    }

    public function deleteEvent()
    {
        $rules = [
            'event_id' => 'required|integer',
        ];

        $request = $this->apiRequest->getRequestInput($this->request);
        if (!$this->apiRequest->validateRequest($request, $rules)) {
            return $this->fail($this->apiRequest->validator->getErrors());
        }


        return $this->setResponseFormat('json')->respond($this->eventRepositories->deleteEvent($request), 200);
    }
}
