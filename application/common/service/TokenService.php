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
}
