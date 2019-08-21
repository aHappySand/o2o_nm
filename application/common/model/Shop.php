<?php

namespace app\common\model;

use app\common\model\Base;

class Shop extends Base
{
    const STATUS_NORMAL = 2;//正常
    const STATIS_WAIT = 1;//待审
    const STATUS_DELETE = 0;//删除
}
