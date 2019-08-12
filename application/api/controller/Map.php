<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/11
 * Time: 15:30
 */

namespace app\api\controller;

use app\api\controller\BusinessBase;

class Map extends BusinessBase
{
    public function test(){
        return json_encode(['111']);
    }
    public function geoCode(){
        $address = input('address');
        if(input('map') == 'gd'){
            $arrMsg = \Amap::getGeoCode($address);
        }else{
            $arrMsg = \Bmap::getGeoCode($address);
            $arrMsg['location'] = $arrMsg['location']['lat'] . ',' .$arrMsg['location']['lng'];
            $arrMsg = array($arrMsg);
        }
        if(is_array($arrMsg)){
            return $this->runtSuccess('获取成功', $arrMsg);
        }else{
            return $this->runtError('获取失败',0, array('msg'=> $arrMsg));
        }
    }

    public function  staticMap(){
        $arrLoc = explode(',', input('location'));
        $jd = '';
        $wd = '';
        if(count($arrLoc) == 2){//传入经纬度
            $jd = $arrLoc[0];
            $wd = $arrLoc[1];
        }else{
            $jd = input('location');
        }
        if(input('map') == 'gd'){
            $src = \Amap::getStaticMap($jd, $wd);
        }else{
            $src = \Bmap::getStaticMap($jd, $wd);
        }

        return $this->runtSuccess('获取成功', array('src' => $src));
    }
}