<?php

namespace App\Libraries;

use App\Entities\ApilogsEntity;
use CodeIgniter\Controller;

class Logger extends Controller
{
    public function __construct()
    {
        $this->apilogsEntity = new ApilogsEntity();
    }

    public function writeApiLogs($request, $response, $serviceName)
    {
        $requestHeader = [
            'Authorization' => isset($request['headers']["Authorization"]) ? $request['headers']["Authorization"] : null,
            'Language' => isset($request['headers']["lang"]) ? $request['headers']["lang"] : null,
            'Content-Type' => isset($request['headers']["Content-Type"]) ? $request['headers']["Content-Type"] : null,
        ];

        $apiLogs = [
            'requestMethod' => strtoupper($request['method']),
            'requestUri' => $request['url'],
            'requestHeaders' => json_encode(array_filter($requestHeader)),
            'requestParams' => isset($request['params']) ? json_encode($request['params']) : '',
            'requestBody' => isset($request['payloads']) ? json_encode($request['payloads']) : '',
            'responseBody' => json_encode($response),
            'serviceName' => $serviceName,
        ];

        return $this->apilogsEntity->insert($apiLogs);
    }
}
