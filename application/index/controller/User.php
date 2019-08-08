<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/6
 * Time: 23:06
 */

namespace app\index\controller;

use think\Controller;

class User extends Controller
{
    public function login(){
        return $this->fetch();
    }

    public function regist(){
        return $this->fetch();
    }
}