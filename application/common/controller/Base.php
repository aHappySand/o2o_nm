<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/12
 * Time: 13:36
 */

namespace app\common\controller;


use QL\QueryList;
use think\Controller;
use think\Db;
use think\Loader;

class Base extends Controller
{
    protected $isAjax = false;

    protected function initialize()
    {
        parent::initialize();
        $this->uploadBaseUrl = $this->request->domain() . '/upload/';
    }

    public function setIsAjax($value = true)
    {
        $this->isAjax = $value;
    }

    public function runtView($default = '')
    {
        $action = request()->action();
        $controller = Loader::parseName(request()->controller());
        $model = Loader::parseName(request()->module());
        if (empty($default)) {
            $default = 'default/' . $model . '/' . $controller . '/' . $action;
        } else {
            $default = 'default/' . $model . '/' . $action . '/' . $default;
        }
        return $this->fetch($default);
    }

    /**
     * ajax返回处理方法
     * @param $error
     * @param $msg
     * @param array $data
     * @return array
     */
    protected function ajaxDone($error, $msg, $data = [])
    {
        $ret = array(
            'error' => $error,
            'code' => $error,
            'msg' => $msg,
            'data' => []
        );

        if (!empty($data['jump_url'])) {
            $ret['jump_url'] = $data['jump_url'];
            unset($data['jump_url']);
        }
        if (!empty($data)) {
            $ret['data'] = $data;
        }
        exit(json_encode($ret));
    }

    /**
     * ajax成功返回方法
     * @param $msg
     * @param array $data
     * @return array
     */
    public function ajaxSuccess($msg, $data = [])
    {
        return $this->ajaxDone(0, $msg, $data);
    }

    /**
     * ajax失败返回方法
     * @param $msg
     * @param int $error
     * @param array $data
     * @return array
     */
    public function ajaxFail($msg, $error = 1, $data = [])
    {
        return $this->ajaxDone($error, $msg, $data);
    }

    /**
     * 自定义成功返回方法
     * @param $msg
     * @param array $data
     * @return array|void
     */
    protected function runtSuccess($msg, $data = [])
    {
        if (request()->isAjax() || $this->isAjax === true) {
            return $this->ajaxSuccess($msg, $data);
        }
        $url = null;
        if (!empty($data['jump_url'])) {
            $url = $data['jump_url'];
            unset($data['jump_url']);
        }
        $wait = 3;
        if (!empty($data['jump_wait_time'])) {
            $wait = $data['jump_wait_time'];
            unset($data['jump_wait_time']);
        }
        $header = [];
        if (!empty($data['header'])) {
            $header = $data['header'];
            unset($data['header']);
        }

        return $this->success($msg, $url, $data, $wait, $header);
    }

    /**
     * 自定义失败返回方法
     * @param $msg
     * @param int $error
     * @param array $data
     * @return array|void
     */
    protected function runtError($msg, $error = 1, array $data = array())
    {
        if (request()->isAjax() || $this->isAjax === true) {
            return $this->ajaxFail($msg, $error, $data);
        }
        $url = null;
        if (!empty($data['jump_url'])) {
            $url = $data['jump_url'];
            unset($data['jump_url']);
        }
        $wait = 3;
        if (!empty($data['jump_wait_time'])) {
            $wait = $data['jump_wait_time'];
            unset($data['jump_wait_time']);
        }
        $header = [];
        if (!empty($data['header'])) {
            $header = $data['header'];
            unset($data['header']);
        }

        return $this->error($msg, $url, $data, $wait, $header);
    }

    /**
     * 返回 json数据分页
     * @param $data
     * @param $total
     * @param string $msg
     * @return array
     */
    public function ajaxPage($data, $total, $msg = '返回列表')
    {
        return [
            'code' => 0,
            'msg' => $msg,
            'count' => $total,
            'data' => $data
        ];
    }

    /**
     * 生成Select Tree公共方法
     * @param $data
     * @param int $currentValue
     * @return string
     * @throws \Exception
     */
    protected function createSelectTree($data, $currentValue = 0)
    {
        $tree = new \Tree();
        $tree->setKeyName('id');
        if ($currentValue) {
            $tree->setCurrentKeyValue($currentValue);
        }
        $tree->setTree($data);
        $template = $this->fetch('public/tree_option');
        $optionTree = $tree->sprintfTree($template);
        return $optionTree;
    }

    public function createTree($data, $currentValue = 0)
    {
        $tree = new \Tree();
        $tree->setKeyName('id');
        if ($currentValue) {
            $tree->setCurrentKeyValue($currentValue);
        }
        $tree->setTree($data);
        /*$template = $this->fetch('public/tree_option');
        $optionTree = $tree->sprintfTree($template);*/
        return $tree->getTree();
    }

    protected function pay($tradeNo)
    {
        set_time_limit(0);
        header("Content-type:text/html;Charset=utf8");
        $cookie = 'cna=NvL2FEGkhA4CATutN8pkNa/o; mobileSendTime=-1; credibleMobileSendTime=-1; ctuMobileSendTime=-1; riskMobileBankSendTime=-1; riskMobileAccoutSendTime=-1; riskMobileCreditSendTime=-1; riskCredibleMobileSendTime=-1; riskOriginalAccountMobileSendTime=-1; NEW_ALIPAY_TIP=1; unicard1.vm="K1iSL1gn5tiRQsDYLU0ClQ=="; isg=BIOD9vGx2vcJYpeOYdZ44k2ZEkct-Bc6S2Ga_LVg3-JZdKOWPcinimHm7kSfT28y; l=bBLXcg2lvoL72VNyBOCanurza77OSIRYYuPzaNbMi_5dp6Tsba7Okvw7nF96Vj5RsOYB4ufw3g99-etkZ; csrfToken=fnneGYvJxeudY_7jRQbQY_hW; alipay="K1iSL1gn5tiRQsDYLU0Cldh21N7L48ve4/xyaNOR43EydRKd"; CLUB_ALIPAY_COM=2088102330909054; iw.userid="K1iSL1gn5tiRQsDYLU0ClQ=="; ali_apache_tracktmp="uid=2088102330909054"; session.cookieNameId=ALIPAYJSESSIONID; JSESSIONID=5940FEF9E2A6178CE6D5F0B9792291D7; spanner=VXs63DRFZtmtoAcFxS+/zDUP4rGCaAxZXt2T4qEYgj0=; ctoken=4pmF3j7n7HDlk95o; LoginForm=alipay_login_auth; ALIPAYJSESSIONID=RZ13NdUnC3BkVONmIKOZ5UXTML08wDauthRZ41GZ00; zone=GZ00C; rtk=HG219aOZRsqWCLm2zG2JUj3UEIDAdTFn6FcpBQJgLXFYhNCRBf6';
        $setting = Db::name('setting')->field('var,val')->where('var', 'alipay_cookie')->find();
        $cookie = $setting['val'];
        $url = 'https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=' . $tradeNo;
        $cookieFile = dirname(APP_PATH) . "/public/" . 'cookie.txt';
        $cookieFile = realpath($cookieFile);
        $ssl = substr($url, 0, 8) == "https://" ? true : false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie); //使用上面获取的cookies
        //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); //使用上面获取的cookies
        if ($ssl === true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);              // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);              // 从证书中检查SSL加密算法是否存在
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        $rule = [
            'price' => ['tbody>tr>.price', 'text'],
        ];
        $data = QueryList::Query($response, $rule, '', 'UTF-8', 'GB2312')->data;
        if (empty($data)) {
            return 'false';
        } else {
            return intval($data[0]['price']);
        }
    }
}