<?php

namespace App\Libraries;

use App\Libraries\Logger;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;

class APIRequest
{
    public function __construct()
    {
        $this->logger = new Logger();
        $this->curl = Services::curlrequest();
    }

    public function getRequestInput(IncomingRequest $request)
    {
        $requestHeader = [
            'Authorization' => $request->getHeaderLine("Authorization"),
            'Language' => $request->getHeaderLine("lang"),
            'Content-Type' => $request->getHeaderLine("Content-Type"),
            // 'Park' => $request->getHeaderLine("Park"),
        ];

        $input['method'] = $request->getMethod();
        $input['url'] = $request->uri->getPath();
        $input['headers'] = $requestHeader;
        $input['payloads'] = $request->getPost();
        $input['params'] = $request->getGet();
        if (empty($input['payloads'])) {
            $input['payloads'] = json_decode($request->getBody(), true);
        }
        return $input;
    }

    public function validateRequest($input, array $rules, array $messages = [])
    {
        $this->validator = Services::Validation()->setRules($rules);
        if (is_string($rules)) {
            $validation = config('Validation');
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->$errorName ?? [];
            }
            $rules = $validation->$rules;
        }
        if ($input['method'] == 'get') {
            return $this->validator->setRules($rules, $messages)->run($input['params']);
        } else {
            return $this->validator->setRules($rules, $messages)->run($input['payloads']);
        }
    }

    public function cURL($arg)
    {
        try {
            $method = isset($arg['method']) ? $arg['method'] : '';
            $endpoint = isset($arg['endpoint']) ? $arg['endpoint'] : '';
            $headers = isset($arg['headers']) ? $arg['headers'] : '';
            $payloads = isset($arg['payloads']) ? $arg['payloads'] : '';
            $params = isset($arg['params']) ? $arg['params'] : '';
            $serivce = isset($arg['serivce']) ? $arg['serivce'] : '';

            if ($method == 'POST') {
                $result = $this->curl->request('POST', $endpoint, [
                    'headers' => $headers,
                    'body' => $payloads,
                    'form_params' => $payloads,
                ]);

                $newRequest = [
                    'headers' => $headers,
                    'method' => $method,
                    'url' => $endpoint,
                    'payloads' => $payloads,
                ];
                $this->logger->writeApiLogs($newRequest, $result, $serivce);
            } else {
                $result = $this->curl->request('GET', $endpoint, [
                    'headers' => $headers,
                    'query' => $params,
                ]);

                $newRequest = [
                    'headers' => $headers,
                    'method' => $method,
                    'url' => $endpoint,
                    'params' => $params,
                ];
                $this->logger->writeApiLogs($newRequest, $result, $serivce);
            }
            return json_decode($result->getBody(), true);
        } catch (Exception $e) {
            $result = array(
                'resultCode' => $e->getCode(),
                'resultMessage' => $e->getMessage(),
            );
            return $result;
        }
    }
}
