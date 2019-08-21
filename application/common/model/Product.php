<?php

namespace app\common\model;

use app\common\model\Base;

class Product extends Base
{
    public function getStartTimeAttr($value, $data)
    {
        return date("Y-m-d H:i:s", $value);
    }

    public function getEndTimeAttr($value, $data)
    {
        return date("Y-m-d H:i:s", $value);
    }
}
