<?php

namespace app\common\service;

use app\common\model\TradeArea;
use app\common\service\BaseService;

class TradeAreaService extends BaseService
{
    public function __construct()
    {
        $this->model = new TradeArea();
    }
}
