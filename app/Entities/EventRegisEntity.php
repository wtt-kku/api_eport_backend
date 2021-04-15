<?php

namespace App\Entities;

use CodeIgniter\Model;

class EventRegisEntity extends Model
{
    protected $table = 'eventregister';
    protected $primaryKey = 'eventregister_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'event_id',
        'member_id',
        'status',
    ];
}
