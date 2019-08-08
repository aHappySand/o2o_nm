<?php

namespace app\common\service;

use app\common\service\BaseService;
use app\common\model\Product;

class ProductService extends BaseService
{
    public function __construct()
    {
        $this->model = new Product();
    }
}
