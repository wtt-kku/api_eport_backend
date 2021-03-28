<?php

namespace App\Entities;

use CodeIgniter\Model;

class CategoryEntity extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'category_id',
        'category_name',
    ];
}
