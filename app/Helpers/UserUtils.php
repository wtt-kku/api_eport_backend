<?php

namespace App\Helpers;

use \Firebase\JWT\JWT;

class UserUtils
{
    public function jwtDecodeToken($token)
    {
        try {
            $response = (array) JWT::decode($token, JWT_KEY, array(JWT_ALGORITHM));
            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'Success',
                'data' => $response,
            );
        } catch (\Firebase\JWT\InvalidArgumentException $e) {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'Invaild Token',
            );
        } catch (\Firebase\JWT\ExpiredException $e) {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'Expired token',
            );
        } catch (\Exception $e) {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'Unauthorized',
            );
        }
        return $result;
    }

    public function jwtEncodeToken($data, $expire)
    {
        try {
            $data['iat'] = time();
            $data['exp'] = $expire;
            $result = JWT::encode($data, JWT_KEY);
            return $result;
        } catch (\Exception $e) {
            $result = array(
                'resultCode' => 500,
                'resultMessage' => 'failed',
            );
            return $result;
        }
    }

    public function checkPermission($token, $id_owner, $usertype)
    {
        try {
            $decode = (array) JWT::decode($token, JWT_KEY, array(JWT_ALGORITHM));
            if (($id_owner == $decode['id']) && ($usertype ==  $decode['account_type'])) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getIdbyToken($token)
    {
        try {
            $decode = (array) JWT::decode($token, JWT_KEY, array(JWT_ALGORITHM));
            return $decode['id'];
        } catch (\Exception $e) {
            return "";
        }
    }
}
