<?php

namespace App\Entities;

use CodeIgniter\Model;

class CouEntity extends Model
{
    protected $table = 'cou';
    protected $primaryKey = 'cou_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'cou_id',
        'cou_type',
        'cou_name_th',
        'cou_name_en',
        'cou_description',
        'cou_tax_id',
        'phone',
        'cou_username',
        'cou_password',
        'cou_email',
        'address',
        'amphur_id',
        'province_id',
        'status'
    ];
}
