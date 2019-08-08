<?php

namespace app\common\service;

use app\common\service\BaseService;
use app\common\service\Coupon;

class CouponService extends BaseService
{
    public function __construct()
    {
        $this->model = new Coupon();
    }
}
