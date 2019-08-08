<?php

namespace app\common\service;

use app\common\service\BaseService;
use app\common\model\City;

class CityService extends BaseService
{
    public function __construct()
    {
        $this->model = new City();
    }
}
