<?php

namespace app\common\service;

use app\common\service\BaseService;
use app\common\model\Shop;

class ShopService extends BaseService
{
    public function __construct()
    {
        $this->model = new Shop();
    }
}
