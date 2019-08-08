<?php

namespace app\common\service;

use app\common\service\BaseService;

use app\common\model\Business;

class BusinessService extends BaseService
{
    public function __construct(){
        $this->model = new Business();
    }
}
