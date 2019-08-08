<?php

namespace app\common\service;

use app\common\model\ShopManager;
use app\common\service\BaseService;


class ShopManagerService extends BaseService
{
    public function __construct()
    {
        $this->model = new ShopManager();
    }
}
