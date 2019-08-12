<?php
namespace app\business\controller;

use app\common\controller\Base;
use app\common\service\CityService;

class Registe extends Base
{
    public function index()
    {
        $city = new CityService();
        $citys = $city->all(array('level' => 2), array('cityCode' => 'asc'));
        $this->assign('citys', $citys);
        return $this->fetch();
    }
}