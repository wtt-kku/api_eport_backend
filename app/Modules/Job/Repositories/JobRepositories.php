<?php

namespace App\Modules\Job\Repositories;

use App\Libraries\Logger;
use App\Modules\Job\Models\JobModel;

use CodeIgniter\Controller;

class JobRepositories extends Controller
{
    private $jobModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->jobModel = new JobModel();
    }
}
