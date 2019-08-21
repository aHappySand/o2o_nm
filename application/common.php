<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
function categoryStatus($status){
    switch($status){
        case 2:
            $str = "<span class='label label-success radius'>正常</span>";
            break;
        case 1:
            $str = "<span class='label label-default radius'>待审</span>";
            break;
        case 0:
            $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

function array2Query ($arr) {
    $keys = [];
    foreach ($arr as $key => $val) {
        array_push($keys, $key. '=' .$val);
    }
    return join('&', $keys);
}



/**
 * 判断当前目录使用有文件，如果没有 找当前模块
 * @param $name
 * @param string $path
 * @return mixed
 */

function runt_service($name, $path = '')
{
    $servicePath = 'service';
    if (!empty($path)) {
        $servicePath = 'service\\' . $path;
    }

    return Loader::model($name, $servicePath);
}

/**
 * 404
 * @param string $msg
 */
function runt_404($msg = '您访问的地址不存在')
{
    header("HTTP/1.1 404 Not Found");
    header("Status: 404 Not Found");
    exit($msg);
}

function runt_show_status($status)
{
    if ($status == 1) {
        return '<i class="Hui-iconfont Hui-iconfont-xuanze c-success"></i>';
    }
    return '<i class="Hui-iconfont Hui-iconfont-close c-error"></i>';
}

if (!function_exists('runt_avatar')) {
    function runt_avatar($img, $width, $height)
    {
        $attachment = app('App\Services\AssetUrlMaker');
        return $attachment->avatar($img, $width, $height);
    }
}

if (!function_exists('runt_thumb')) {
    /**
     *
     * @param $img
     * @param int $width
     * @param int $height
     * @return string
     */
    function runt_thumb($img, $width = 200, $height = 200)
    {
        return 'https://b.u5r.cn/addons/bbd_guessmusic/icon.jpg?v=1539093068';
        $attachment = app('App\Services\AssetUrlMaker');
        return $attachment->thumb($img, $width, $height);
    }
}


if (!function_exists('runt_filter_mobile')) {
    /**
     * 检查手机号是否正确
     * @param $mobile
     * @return bool
     */
    function runt_filter_mobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('/^0?(13|14|15|16|17|18|19)[0-9]{9}$/', $mobile) ? true : false;
    }

    /**
     * 检查邮箱是否正确
     *
     * @param $email
     * @return bool
     */
    function runt_filter_email($email)
    {
        return preg_match('/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/', $email) ? true : false;
    }
}


if (!function_exists('runt_random_number')) {
    /**
     * 生成数字字符串
     * @param int $length
     * @return string
     */
    function runt_random_number($length = 8)
    {
        $pool = '0123456789';
        return mb_substr(str_shuffle(str_repeat($pool, $length)), 0, $length, 'UTF-8');
    }
}


if (!function_exists('runt_random')) {
    /**
     * 生成数字字符串
     * @param int $length
     * @return string
     */
    function runt_random($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return mb_substr(str_shuffle(str_repeat($pool, $length)), 0, $length, 'UTF-8');
    }
}

if (!function_exists('runt_create_salt')) {
    /**
     * 生成salt
     * @param int $length
     * @return string
     */
    function runt_create_salt($length = 64)
    {
        return runt_random($length);
    }
}


if (!function_exists('runt_hash_password')) {
    /**
     * 加密密码
     * @param int $length
     * @return string
     */
    function runt_hash_password($pwd, $salt)
    {
        return md5(md5($pwd) . $salt);
    }
}


if (!function_exists('rand_ip')) {
    function rand_ip()
    {
        $ip2id = round(rand(600000, 2550000) / 10000);
        $ip3id = round(rand(600000, 2550000) / 10000);
        $ip4id = round(rand(600000, 2550000) / 10000);
        $arr_1 = array("218", "218", "66", "66", "218", "218", "60", "60", "202", "204", "66", "66", "66", "59", "61", "60", "222", "221", "66", "59", "60", "60", "66", "218", "218", "62", "63", "64", "66", "66", "122", "211");
        $randarr = mt_rand(0, count($arr_1) - 1);
        $ip1id = $arr_1[$randarr];
        return $ip1id . "." . $ip2id . "." . $ip3id . "." . $ip4id;
    }
}


function list_dir($dir)
{
    $result = array();
    if (is_dir($dir)) {
        $file_dir = scandir($dir);
        foreach ($file_dir as $key => $file) {

            if ($file == '.' || $file == '..') {
                continue;
            } elseif (is_dir($dir . $file)) {

                $result = array_merge($result, $this->list_dir($dir . $file . '/'));
            } else {

                array_push($result, $dir . $file);
            }
        }
    }
    return $result;
}


function add_file_to_zip($path, $zip)
{
    $handler = opendir($path);
    while (($filename = readdir($handler)) !== false) {
        if ($filename != "." && $filename != "..") {
            if (!is_dir($filename)) {
                $zip->addFile($path . "/" . $filename, $filename); //第二个参数避免将目录打包，可以不加
            }
        }
    }
    @closedir($path);
}

function curl_post($url, $data)
{
    $postData = http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function send_sms_curl_253($url, $data)
{
    $postData = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
        )
    );
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); //若果报错 name lookup timed out 报错时添加这一行代码
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec($ch);
    if (false == $ret) {
        $result = [
            'code' => '400' . curl_error($ch),
            'errorMsg' => 'POST错误'
        ];
        $result = json_encode($result);
    } else {
        $rsp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 != $rsp) {
            $result = [
                'code' => '400' . curl_error($ch),
                'errorMsg' => '请求状态' . $rsp . curl_error($ch)
            ];
            $result = json_encode($result);
        } else {
            $result = $ret;
        }
    }
    curl_close($ch);
    return $result;
}

function send_sms_253($mobile, $msg, $needStatus = 'false', $extno = '')
{
    $config = config('sms.253');
    $postArr = array(
        'account' => $config['account'],
        'password' => $config['password'],
        'msg' => urlencode($msg),
        'phone' => $mobile,
        'report' => $needStatus,
    );
    $result = send_sms_curl_253($config['send_url'], $postArr);
    return $result;
}

function data_auth_sign($data)
{
    if (!is_array($data)) {
        $data = (array)$data;
    }
    ksort($data);
    $str = http_build_query($data);
    $sign = sha1($str);
    return $sign;
}

function time_to_day($time, $emptyStr = '')
{
    if (empty($time)) {
        return $emptyStr;
    }
    if (is_numeric($time)) {
        return date('Y-m-d', $time);
    }
    return date('Y-m-d', strtotime($time));
}

function time_to_full($time, $emptyStr = '')
{
    if (empty($time)) {
        return $emptyStr;
    }
    if (is_numeric($time)) {
        return date('Y-m-d H:i:s', $time);
    }
    return $time;
}

function format_money($money)
{
    if (empty($money)) {
        return '0.00';
    }
    return sprintf("%.2f", $money / 100);
}

function format_money_yuan($money, $emptyStr = '')
{
    if (empty($money)) {
        return $emptyStr;
    }
    return sprintf("%.0f", $money / 100);
}

function get_jd_goods_id($url)
{
    return trim(trim(parse_url($url, PHP_URL_PATH), '/'), '.html');
}

function get_tb_goods_id($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $output);
    return isset($output['id']) ? trim($output['id']) : '';
}

function create_token($id, $out_time)
{
    return substr(md5($id . $out_time.time()), 5, 26);
}

function show_safe_str($string, $star = 4, $end = 3)
{
    $len = strlen($string);
    $hideLen = $len - $star - $end;
    $replace = '';
    for ($i = 0; $i < $hideLen; $i++) {
        $replace .= '*';
    }
    $pattern = "/(\d{" . $star . "})\d{" . $hideLen . "}(\d{" . $end . "})/";
    $replacement = "\$1" . $replace . "\$2";
    return preg_replace($pattern, $replacement, $string);
}

function process_show_str($string)
{
    $arr = mb_str_split($string);
    foreach ($arr as $key => $val) {
        if ($key % 2 == 1) {
            $arr[$key] = '*';
        }
    }

    return join('', $arr);
}

function avatar($url)
{
    if (empty($url)) {
        $url = 'avatar.png';
    }
    if (strpos($url, 'http') !== false) {
        return $url;
    }

    return request()->domain() . '/upload/' . $url;
}

function thumb($url)
{
    if (empty($url)) {
        $url = 'avatar.png';
    }
    if (strpos($url, 'http') !== false) {
        return $url;
    }
    if (strpos($url, '//') !== false) {
        return $url;
    }
    return request()->domain() . '/upload/' . $url;
}


/**
 * 将字符串分割为数组
 * @param $str 字符串
 * @return array[]|false|string[] 分割得到的数组
 */
function mb_str_split($str)
{
    return preg_split('/(?<!^)(?!$)/u', $str);
}

/**
 * 十进制数转换成三十六机制数
 * @param $num 十进制数
 * @return bool|string 三十六进制数
 */
function get_char($num)
{
    $num = intval($num);
    if ($num <= 0)
        return false;
    $charArr = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $char = '';
    do {
        $key = ($num - 1) % 36;
        $char = $charArr[$key] . $char;
        $num = floor(($num - $key) / 36);
    } while ($num > 0);
    return $char;
}

/**
 * 三十六进制数转换成十机制数
 * @param $char 三十六进制数
 * @return float|int  返回：十进制数
 */
function get_num($char)
{
    $array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $len = strlen($char);
    $sum = 0;
    for ($i = 0; $i < $len; $i++) {
        $index = array_search($char[$i], $array);
        $sum += ($index + 1) * pow(36, $len - $i - 1);
    }
    return $sum;
}

function tb_commission($price)
{
    return 9 + ceil($price / 50) * 1;
}

function jd_pdd_commission($price)
{
    return 4 + ceil($price / 50) * 1;
}

function price_list()
{
    $j = 0;
    $price = [];
    for ($i = 50; $i <= 5050; $i += 100) {
        $price[] = [
            'max' => $i,
            'tb_commission' => 8 + $j,
            'jd_commission' => 4 + $j,
            'pdd_commission' => 4 + $j,
        ];
        $j++;
    }
    $price[] = [
        'max' => 999999,
        'tb_commission' => 198,
        'jd_commission' => 99.5,
        'pdd_commission' => 99.5,
    ];
    return $price;
}

function get_task_commission($price, $platform)
{
    $priceList = price_list();
    $plat = $platform;
    switch ($platform) {
        case 1:
            $plat = 'tb';
            break;
        case 3:
            $plat = 'jd';
            break;
        case 5:
            $plat = 'pdd';
            break;
    }

    $commission = $priceList[0][$plat . '_commission'];
    $priceList = array_reverse($priceList);
    foreach ($priceList as $key => $val) {
        if ($price <= $val['max']) {
            $commission = $val[$plat . '_commission'];
        }
    }
    return $commission;
}

function task_day($startDate, $endDate)
{
    $day = (strtotime($endDate) - strtotime($startDate)) / 86400;

    return $day + 1;
}

function platform_name($platform)
{
    $platformName = '';
    switch ($platform) {
        case 1:
            $platformName = '淘宝';
            break;
        case 2:
            $platformName = '京东';
            break;
        case 3:
            $platformName = '拼多多';
            break;
        case 4:
            $platformName = '抖音';
            break;
    }
    return $platformName;
}

function create_sms_code($len = 4)
{
    $code = mt_rand(1, 9);
    $len--;
    for ($i = 0; $i < $len; $i++) {
        $code .= mt_rand(0, 9);
    }
    return $code;
}

function guzzle_get($url, $option, $isJsonDecode = true)
{
    $client = new \GuzzleHttp\Client();
    $data = $client->request('GET', $url, $option)->getBody()->getContents();
    return $isJsonDecode ? json_decode($data, true) : $data;
}

function guzzle_post($url, $option, $isJsonDecode = true)
{
    $client = new \GuzzleHttp\Client();
    $data = $client->request('POST', $url, $option)->getBody()->getContents();
    return $isJsonDecode ? json_decode($data, true) : $data;
}

function getRandomIp($num)
{
    try {
        $data = guzzle_get('http://hichina.v4.dailiyun.com/query.txt', [
            'query' => [
                'key' => 'NP55FCE345',
                'word' => '',
                'rand' => 'false',
                'count' => $num,
                'detail' => 'true'
            ]
        ], false);
        $ipArr = [];
        $arr = explode("\r\n", $data);
        foreach ($arr as $k => $v) {
            $ipPortStr = explode(',', $v);
            $res = reset($ipPortStr);
            if (empty($res)) {
                continue;
            }
            $ipPort = explode(':', $res);
            $ipArr[] = ['ip' => reset($ipPort), 'port' => end($ipPort)];
        }
        return $ipArr;
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        getRandomIp($num);
    }
}

/**
 * 字符串切割成数组
 *
 * @param $str
 * @return array
 */
function str_to_array($str)
{
    $strReplace = str_replace(["\r", "\n", '|', ',', '，', "\r\n"], ',', $str);
    return array_filter(explode(",", $strReplace));
}

function get_tree($data, $pid = 0)
{
    $tree = array();
    foreach ($data as $k => $v) {
        if ($v["pid"] == $pid) {
            //unset($data[$k]);
            if (!empty($data)) {
                $children = get_tree($data, $v["value"]);
                if (!empty($children)) {
                    $v["children"] = $children;
                }
            }
            $tree[] = $v;
        }
    }
    return $tree;
}

function is_mobile($mobile)
{
    return runt_filter_mobile($mobile);
}

/**
 * @description 解析URL中的参数
 * @param $url
 * @return array
 */
function convertUrlQuery($url){
    $arrURL = parse_url($url);
    $arrQuery = explode("&", $arrURL["query"]);
    $arrParam = array();
    foreach($arrQuery as $val){
        $arrTmp = explode("=", $val);
        $arrParam[$arrTmp[0]] = $arrTmp[1];
    }
    return $arrParam;
}

function getRealIp()
{
    $ip=false;
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}