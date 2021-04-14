<?php

namespace App\Entities;

use CodeIgniter\Model;

class JobRegisEntity extends Model
{
    protected $table = 'jobregister';
    protected $primaryKey = 'jobregister_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'job_id',
        'member_id',
        'status',
    ];
}
