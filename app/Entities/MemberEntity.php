<?php

namespace App\Entities;

use CodeIgniter\Model;

class MemberEntity extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'member_id ';
    protected $returnType = 'array';
    protected $allowedFields = [
        'username',
        'password',
        'member_email',
        'firstname',
        'lastname',
        'gender',
        'idcard',
        'address',
        'anphur_id',
        'province_id',
        'phone',
        'status'
    ];
}
