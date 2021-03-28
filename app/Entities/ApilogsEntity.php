<?php

namespace App\Entities;

use CodeIgniter\Model;

class ApilogsEntity extends Model
{
    protected $table = 'apilogs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id',
        'requestMethod',
        'requestUri',
        'requestHeaders',
        'requestParams',
        'requestBody',
        'responseBody',
        'serviceName',
    ];
}
