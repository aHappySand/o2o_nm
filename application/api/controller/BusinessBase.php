<?php
/**
 * BusinessBase.php
 *
 * @data 19/6/8 
 * @author Henry <8323216@qq.com>
 * @link http://www.hisun360.com/
 * @copyright Copyright© 2012 - 2015 HISUN. All Rights Reserved.
 */

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