<?php

namespace app\common\service;

use app\common\service\BaseService;
use app\common\model\Shop;

class ShopService extends BaseService
{
    public function __construct()
    {
        $this->model = new Shop();
    }

    public function getShopList()
    {
        $user = session_business('login_user');
        return $this->model->name('shop')
            ->where(array('uid' => $user->id, 'status' => ['<>', Shop::STATUS_DELETE]))
            ->order('create_time', 'desc')
            ->paginate(1);
    }
}
