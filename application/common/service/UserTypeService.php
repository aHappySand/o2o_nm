<?php
namespace app\common\service;

use app\common\model\UserType;
use app\common\service\BaseService;

class UserTypeService extends BaseService
{
    public function __construct()
    {
        $this->model = new UserType();
    }
}