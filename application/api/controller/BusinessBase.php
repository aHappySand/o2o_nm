<?php
namespace app\api\controller;


use app\common\controller\Base;
use think\App;

class BusinessBase extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->setIsAjax(true);
    }

}