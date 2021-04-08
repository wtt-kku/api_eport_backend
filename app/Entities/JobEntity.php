<?php

namespace App\Entities;

use CodeIgniter\Model;

class JobEntity extends Model
{
    protected $table = 'job';
    protected $primaryKey = 'job_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'category_id',
        'job_name',
        'job_description',
        'salary',
        'status',
        'cou_id',
    ];
}
