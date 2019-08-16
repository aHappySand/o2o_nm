<?php
namespace app\business\controller;

use app\common\controller\Base;
use app\common\service\BusinessUserService;
use app\common\service\TokenService;
use think\Cache;
use think\captcha\Captcha;

class Login extends Base
{
    public function index()
    {
//        $map = \Bmap::getGeoCode('武汉天祥尚府');
//        print_r($map);exit;


        return $this->fetch();
    }

    /**
     * 生成验证码
     * @return \think\Response
     */
    public function captcha()
    {
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    30,
            // 验证码位数
            'length'      =>    4,
            // 关闭验证码杂点
            'useNoise'    =>    false,
        ];
        $captcha = new Captcha($config);
//        $captcha->genIm();
        return $captcha->entry();
    }

    public function checkAll()
    {

        return $this->runtError('输入次数过多，请输入验证码', 5);
        //查询登陆的次数
        $lgtimes = Cache::get('login_times');
        if(empty($lgtimes)){
            Cache::set('login_times', 1);
        }else if($lgtimes == 5){//输入用户名超过5次
            return $this->runtError('输入次数过多，请输入验证码', 5, array('img' => $this->captcha()));
        }else{
            Cache::set('login_times', 1+$lgtimes);
        }

        $username = input('username');
        $user = new BusinessUserService();
        $one = $user->one(array('username' => $username));
        if(empty($one)){
            return $this->runtError('用户名或密码错误');
        }

        $pw = input('password');
        $saltpw = runt_hash_password($pw, $one->pw_salt);
        if($saltpw != $one->password){
            return $this->runtError('用户名或密码错误');
        }
        return $this->runtSuccess('都正确');
    }

    public function login()
    {
        $username = input('username');
        $pw = input('password');

        $data = array(
            'last_login_ip' => getRealIp(),
            'last_login_time' => time(),
        );

        $user = new BusinessUserService();
        $one = $user->one(array('username' => $username));

        $user->edit($data, array('id' => $one->id));

        $token = new TokenService();
        $data = array(
            'uid' => $one->id,
            'token_val' => create_token($one->id, 3600),
            'token_type' => 1,
            'time_out' => 3600
        );
        $newToken = $token->create($data);
        if(!empty($newToken)){
            $this->redirect('business/index/index');
        }
        return $this->runtError('登录失败');
    }

    /**
     * 检查用户名是否有效
     */
    public function checkName()
    {
        //查询登陆的次数
        $lgtimes = Cache::get('login_times');
        if(empty($lgtimes)){
            Cache::set('login_times', 1);
        }else if($lgtimes == 5){//输入用户名超过5次
            return $this->runtError('输入次数过多', '5');
        }else{
            Cache::set('login_times', 1+$lgtimes);
        }
//    Cache::clear('login_times');
        $username = input('username');
        $user = new BusinessUserService();
        $one = $user->one(array('username' => $username));
        if(!empty($one)){
            $this->runtError('用户名已存在！');
        }
        return $this->runtSuccess('用户名有效');
    }
}