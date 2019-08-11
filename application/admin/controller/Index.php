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

    /**
     * 首页
     */
    public function home(){

//        \phpmailer\Mailer::sendEmail('1125980522@qq.com', 'test', '可以吗？');

        return $this->fetch();
    }
}
