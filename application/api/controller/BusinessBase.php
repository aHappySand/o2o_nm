<?php
namespace app\api\controller;


use app\common\controller\Base;
use think\App;

class BusinessBase extends Base
{
    public function initialize()
    {
        parent::initialize();
        $this->setIsAjax(true);
    }

}