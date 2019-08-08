<?php

namespace app\common\service;

use app\common\service\BaseService;

class MemberService extends BaseService
{
    public function __construct()
    {
        $this->model = new Member();
    }
}
