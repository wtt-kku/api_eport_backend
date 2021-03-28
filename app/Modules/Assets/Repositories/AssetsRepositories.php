<?php

namespace App\Modules\Assets\Repositories;

use App\Libraries\Logger;
use App\Modules\Assets\Models\AssetsModel;

use CodeIgniter\Controller;

class AssetsRepositories extends Controller
{
    private $assetsModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->logger = new Logger();
        $this->assetsModel = new AssetsModel();
    }

    public function getAllProvince($request)
    {
        $response = $this->assetsModel->getProviceList();
        $this->logger->writeApiLogs($request, $response, 'assets_province');
        return $response;
    }
    public function getAmphur($request)
    {
        $provinceId = $request['payloads']['provinceID'];
        $response = $this->assetsModel->getAmphurByProvinceId($provinceId);
        $this->logger->writeApiLogs($request, $response, 'assets_amphur');
        return $response;
    }
    public function getCategory($request)
    {
        $response = $this->assetsModel->getCategory();
        $this->logger->writeApiLogs($request, $response, 'assets_category');
        return $response;
    }
}
