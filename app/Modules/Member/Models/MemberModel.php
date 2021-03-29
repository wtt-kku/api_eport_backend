<?php

namespace App\Modules\Member\Models;

use App\Entities\MemberEntity;
use App\Helpers\UserUtils;

class MemberModel
{
    public function __construct()
    {
        $this->memberEntity = new MemberEntity();
        $this->userUtils = new UserUtils();
        $this->db = \Config\Database::connect();
    }

    public function getMemberLogin($data)
    {
        $query = [
            'username' => $data['username'],
        ];

        $tokenData = [];
        $userTable = $this->db->table('member');
        $query = $userTable->select('*')->where($query)->get()->getResultArray();
        $userData = !empty($query) ? $query[0] : null;
        if (!empty($userData)) {
            if (!password_verify($data['password'], $userData['password'])) {
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
            'member_id' => $data['member_id'],
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'account_type' => 'member'
        );
        $token = $this->userUtils->jwtEncodeToken($setToken, time() + TOKEN_EXPIRE);
        $RefreshToken = $this->userUtils->jwtEncodeToken($setToken, time() + REFRESH_TOKEN_EXPIRE);
        return ['token' => $token, 'RefreshToken' => $RefreshToken];
    }

    public function addMember($data)
    {
        $memberTable = $this->db->table('member');
        $query = $memberTable->select('*')
            ->where('username', $data['username'])
            ->get()->getResultArray();
        $memberData = !empty($query) ? $query[0] : null;

        if (!empty($memberData)) {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'Dupicate username',
            );
            return $result;
        }

        try {
            $this->memberEntity->insert($data);
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

    public function editMember($member_id, $data)
    {
        try {

            $memberTable = $this->db->table('member');
            $query = $memberTable->select('*')
                ->where('member_id', $member_id)
                ->get()->getResultArray();
            $isExist = !empty($query) ? true : false;
            if ($isExist) {
                $this->memberEntity->update($member_id, $data);
                $result = array(
                    'resultCode' => 201,
                    'resultMessage' => 'successfully!',
                );
                return $result;
            } else {
                $result = array(
                    'resultCode' => 401,
                    'resultMessage' => 'your member_id is invalid.'
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

    public function memberPrfoile($member_id)
    {
        $memberTable = $this->db->table('member');
        $query = $memberTable->select('*')
            ->where('member_id', $member_id)
            ->get()->getResultArray();
        $isExist = !empty($query) ? true : false;
        if ($isExist) {
            $filterData = 'member_id,member_email,username,firstname,lastname,gender,idcard,address,phone,province_name_th,amphur_name_th';
            $builder = $this->db->table('member');
            $builder = $builder->select($filterData);
            $builder = $builder->where('member_id', $member_id);
            $builder = $builder->join('province', 'province.province_id  = member.province_id');
            $builder = $builder->join('amphur', 'amphur.amphur_id = member.amphur_id');
            $memberData = $builder->get()->getResultArray();

            $result = array(
                'resultCode' => 200,
                'resultMessage' => 'successfully!',
                'data' => $memberData
            );
        } else {
            $result = array(
                'resultCode' => 401,
                'resultMessage' => 'your member_id is invalid.',
            );
        }
        return $result;
    }
}
