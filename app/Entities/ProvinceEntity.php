<?php

namespace App\Entities;

use CodeIgniter\Model;

class ProvinceEntity extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'province_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'province_id ',
        'code',
        'province_name_th',
        'province_name_en',
    ];
}
