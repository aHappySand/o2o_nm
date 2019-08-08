<?php

namespace app\common\service;


use app\common\model\BusinessUser;

class BusinessUserService extends BaseService
{
    public function __construct()
    {
        $this->model = new BusinessUser();
    }
}
