<?php

namespace App\Modules\Eventreg\Repositories;

use App\Libraries\Logger;
use App\Modules\Eventreg\Models\EventregModel;
use App\Helpers\UserUtils;

use CodeIgniter\Controller;

class EventregRepositories extends Controller
{
    private $eventregModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->eventregModel = new EventregModel();
        $this->userUtils = new UserUtils();
    }

    public function addReg($request)
    {

        $token = $request['headers']['Authorization'];
        $member_id = $request['payloads']['member_id'];
        $permission = $this->userUtils->checkPermission($token, $member_id, "member");
        if ($permission) {
            $data = [
                'member_id' => $request['payloads']['member_id'],
                'event_id' => $request['payloads']['event_id'],
            ];
            $response =  $this->eventregModel->addReg($data);
        } else {
            $response = [
                'resultCode' => 403,
                'resultMessage' => 'Permission denied.',
            ];
        }
        $this->logger->writeApiLogs($request, $response, 'add_event_register');
        return $response;
    }

    public function searchReg($request)
    {
        $condition = [];
        (isset($request['payloads']['member_id']) && $request['payloads']['member_id']) ? $condition["member_id"] = $request['payloads']['member_id'] : false;
        (isset($request['payloads']['event_id']) && $request['payloads']['event_id']) ? $condition["event_id"] = $request['payloads']['event_id'] : false;
        $response =  $this->eventregModel->searchReg($condition);
        $this->logger->writeApiLogs($request, $response, 'search_event_register');
        return $response;
    }
}
