<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/7
 * Time: 22:48
 */

namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    public function index(){

        return $this->fetch();
    }
}