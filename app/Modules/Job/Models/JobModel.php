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
}
