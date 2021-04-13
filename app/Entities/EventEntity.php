<?php

namespace App\Entities;

use CodeIgniter\Model;

class EventEntity extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'event_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'event_name',
        'event_description',
        'full_amount',
        'regis_amount',
        'status',
        'cou_id',
    ];
}
