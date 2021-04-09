<?php

namespace App\Modules\University\Models;

use App\Entities\CouEntity;
use App\Helpers\UserUtils;

class UniversityModel
{
    public function __construct()
    {
        $this->couEntity = new CouEntity();
        $this->userUtils = new UserUtils();
        $this->db = \Config\Database::connect();
    }

    public function getUniversityLogin($data)
    {
        $query = [
            'cou_username' => $data['username'],
            'cou_type' => '1',
        ];

        $tokenData = [];
        $userTable = $this->db->table('cou');
        $query = $userTable->select('*')->where($query)->get()->getResultArray();
        $userData = !empty($query) ? $query[0] : null;
        if (!empty($userData)) {
            if (!password_verify($data['password'], $userData['cou_password'])) {
                // the password is incorrect.
                return [
                    'resultCode' => 401,
                    'resultMessage' => 'username or password invalid',
                ];
            } else {
                $tokenData = $this->CreateToken($userData);
                return [
                    'resultCode' => 200,
                    'resultMessage' => 'login successfully!',
                    'data' => $tokenData
                ];
            }
        } else {
            return [
                'resultCode' => 401,
                'resultMessage' => 'username or password invalid',
            ];
        }
    }

    public function CreateToken($data)
    {
        $setToken = array(
            'id' => $data['cou_id'],
            'account_type' => 'university'
        );
        $token = $this->userUtils->jwtEncodeToken($setToken, time() + TOKEN_EXPIRE);
        $RefreshToken = $this->userUtils->jwtEncodeToken($setToken, time() + REFRESH_TOKEN_EXPIRE);
        return ['token' => $token, 'RefreshToken' => $RefreshToken];
    }

    public function addUniversity($data)
    {
        $memberTable = $this->db->table('cou');
        $query = $memberTable->select('*')
            ->where('cou_username', $data['cou_username'])
            ->where('cou_type', '0')
            ->get()->getResultArray();
        $universityData = !empty($query) ? $query[0] : null;

        if (!empty($universityData)) {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'Dupicate username',
            );
            return $result;
        }

        try {
            $this->couEntity->insert($data);
            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'successfully!',
            );
            return $result;
        } catch (\Exception $e) {
            $result = array(
                'resultCode' => 500,
                'resultMessage' => 'error!'
            );
            return $result;
        }
    }

    public function editUniversity($cou_id, $data)
    {
        try {

            $universityTable = $this->db->table('cou');
            $query = $universityTable->select('*')
                ->where('cou_id', $cou_id)
                ->get()->getResultArray();
            $isExist = !empty($query) ? true : false;
            if ($isExist) {
                $this->couEntity->update($cou_id, $data);
                $result = array(
                    'resultCode' => 201,
                    'resultMessage' => 'successfully!',
                );
                return $result;
            } else {
                $result = array(
                    'resultCode' => 401,
                    'resultMessage' => 'your cou_id is invalid.'
                );
                return $result;
            }
        } catch (\Exception $e) {
            $result = array(
                'resultCode' => 500,
                'resultMessage' => $e
            );
            return $result;
        }
    }

    public function universityProfile($cou_id)
    {
        $memberTable = $this->db->table('cou');
        $query = $memberTable->select('*')
            ->where('cou_id', $cou_id)
            ->where('cou_type', "1")
            ->get()->getResultArray();
        $isExist = !empty($query) ? true : false;
        if ($isExist) {
            $filterData = 'cou_id,cou_name_th,cou_name_en,cou_description,cou_tax_id,phone,cou_email,address,province_name_th,amphur_name_th';
            $builder = $this->db->table('cou');
            $builder = $builder->select($filterData);
            $builder = $builder->where('cou_id', $cou_id);
            $builder = $builder->join('province', 'province.province_id  = cou.province_id');
            $builder = $builder->join('amphur', 'amphur.amphur_id = cou.amphur_id');
            $universityData = $builder->get()->getResultArray();

            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'successfully!',
                'data' => $universityData
            );
        } else {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'your cou_id is invalid.',
            );
        }
        return $result;
    }
}
