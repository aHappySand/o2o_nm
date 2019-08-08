<?php

namespace app\common\service;

use app\common\model\Recommend;
use app\common\service\BaseService;

class RecommendService extends BaseService
{
    public function __construct()
    {
        $this->model = new Recommend();
    }
}
