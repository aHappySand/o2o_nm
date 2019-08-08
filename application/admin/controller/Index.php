<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Config;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
