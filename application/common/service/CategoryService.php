<?php

namespace app\common\service;

use app\common\model\Category;

class CategoryService extends BaseService
{
    public function __construct()
    {
        $this->model = new Category();
    }
}
