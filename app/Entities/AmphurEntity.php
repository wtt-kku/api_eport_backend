<?php

namespace App\Entities;

use CodeIgniter\Model;

class AmphurEntity extends Model
{
    protected $table = 'amphur';
    protected $primaryKey = 'amphur_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'province_id ',
        'code',
        'amphur_name_th',
        'amphur_name_en',
        'province_id',
    ];
}
