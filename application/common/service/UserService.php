<?php
namespace app\common\service;

use app\common\service\BaseService;
use app\common\model\User;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->model = new User();
    }
}