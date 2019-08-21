<?php

namespace app\common\service;

use app\common\service\BaseService;
use app\common\model\Token;

class TokenService extends BaseService
{
    public function __construct()
    {
        $this->model = new Token();
    }

    public function oneByToken($token){
        return $this->model->where('token_val', $token)->find();
    }

    public function createToken($uid)
    {
        $this->model->where('uid', $uid)->delete();
        $data = array(
            'uid' => $uid,
            'token_val' => create_token($uid, 3600),
            'token_type' => 1,
            'time_out' => time() + 3600
        );

        return $this->create($data);
    }
}
