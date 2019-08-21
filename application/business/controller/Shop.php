<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/19
 * Time: 22:55
 */

namespace app\business\controller;


use app\common\service\CategoryService;
use app\common\service\CityService;
use app\common\service\ShopService;

class Shop extends AuthBase
{

    /**
     * 门店列表
     */
    public function index()
    {
        $shopSer = new ShopService();
        $shops = $shopSer->getShopList();
        $this->assign('shops', $shops);
        return $this->fetch();
    }

    /**
     * 新增门店
     */
    public function add()
    {
        if(request()->isPost()){
            // 第一点 检验数据 tp5 validate机制， 小伙伴自行完成
            $data = input('post.');
            $user = $this->getLoginUser();
            $bisId =$user->business_id;
            $category = new CategoryService();
            $oneCategory = $category->one(input('category_id'));
            // 门店入库操作
            // 总店相关信息入库
            $locationData = [
                'uid' => $user->id,
                'business_id' => $bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'category_id' => $data['category_id'],
                'category_path' => $oneCategory->parent_path,
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'description' => empty($data['content']) ? '' : $data['content'],
                'is_main' => 0,
            ];
            $address = $data['address'];
            if($address){
                $map = \Bmap::getGeoCode($address);
                if($map){
                    $locationData['xpoint'] = $map['location']['lat'];
                    $locationData['ypoint'] = $map['location']['lng'];
                }
            }
            $shop = new ShopService();
            $newShop = $shop->create($locationData);

            if(!empty($newShop)) {
                return $this->success('门店申请成功');
            }else {
                return $this->error('门店申请失败');
            }
        }else{
            $city = new CityService();
            $citys = $city->all(array('level' => 1), array('cityCode' => 'asc'));
            $this->assign('citys', $citys);

            $catigory = new CategoryService();
            $catigorys = $catigory->getSelectOption();
            $this->assign('categorys', $catigorys);
            $this->assign('citys', $citys);

            return $this->fetch();
        }
    }
}