<?php

namespace App\Modules\Job\Controllers;

use App\Libraries\APIRequest;
use App\Modules\Job\Repositories\JobRepositories;

class Assets extends BaseController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiRequest = new APIRequest();
        $this->jobRepositories = new JobRepositories();
    }
}
