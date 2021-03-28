<?php

namespace App\Modules\Assets\Models;

use App\Entities\ProvinceEntity;
use App\Entities\AmphurEntity;
use App\Entities\CategoryEntity;

use App\Helpers\UserUtils;

class AssetsModel
{
    public function __construct()
    {
        $this->proviceEntity = new ProvinceEntity();
        $this->amphurEntity = new AmphurEntity();
        $this->categoryEntity = new CategoryEntity();

        $this->db = \Config\Database::connect();
    }

    public function getProviceList()
    {
        $result = $this->proviceEntity->findAll();
        return [
            'resultCode' => 200,
            'resultMessage' => 'successfully!',
            'data' => $result
        ];
    }

    public function getAmphurByProvinceId($provinceId)
    {
        $result = $this->amphurEntity->where('province_id', $provinceId)->findAll();
        return [
            'resultCode' => 200,
            'resultMessage' => 'successfully!',
            'data' => $result
        ];
    }

    public function getCategory()
    {
        $result = $this->categoryEntity->findAll();
        return [
            'resultCode' => 200,
            'resultMessage' => 'successfully!',
            'data' => $result
        ];
    }
}
