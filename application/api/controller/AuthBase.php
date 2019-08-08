<?php
namespace app\api\controller;


use app\api\service\PcTokenService;
use app\api\service\UserService;
use mysql_xdevapi\BaseResult;

class AuthBase extends BusinessBase
{
    public $loginInfo = [];
    public $uid = 0;

    public function initialize()
    {
        parent::initialize();
        $this->checkToken();
    }

    protected function checkToken()
    {
        $token = isset($_SERVER['HTTP_X_TOKEN']) ? $_SERVER['HTTP_X_TOKEN'] : $_GET['token'];
        if (empty($token)) {
            return $this->runtError('没有token', '400201');
        }
        $pcTokenService = new PcTokenService();
        $userToken = $pcTokenService->oneByToken($token);
        if (empty($userToken)) {
            return $this->runtError('token无效', '400202');
        }

        if ($userToken['time_out'] < NOW_TIME) {
            return $this->runtError('token过期', '400203');
        }
        //更新token
        $pcTokenService->extensionTimeOut($token);

        $this->loginInfo = $userToken;
        $this->uid = $userToken['uid'];
    }

    protected function handleTitle($type = 2)
    {
        $title = input('title');
        if (empty($title)) {

            $title = ($type == 2 ? '模板' : '任务') . date('Ymd');
        }
        return $title;
    }

    protected function handleTaskTitle()
    {
        return $this->handleTitle(1);
    }

    protected function checkPayPassword($password)
    {
        $userService = new UserService();
        $userOne = $userService->one($this->uid);
        return runt_hash_password($password, $userOne['pay_salt']) == $userOne['pay_password'];
    }
}