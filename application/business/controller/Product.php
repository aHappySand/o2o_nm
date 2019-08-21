<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/21
 * Time: 21:34
 */

namespace app\business\controller;
use app\common\service\CategoryService;
use app\common\service\CityService;
use app\common\service\ProductService;
use app\common\service\ShopService;

/**
 * 团购商品
 * Class Product
 * @package app\business\controller
 */
class Product extends AuthBase
{
    public function index()
    {
        $user = $this->getLoginUser();

        $product = new ProductService();
        $products = $product->some(array('business_user_id' => $user->id));


        $this->assign('products', $products);
        return $this->fetch();
    }

    public function add()
    {
        $user = $this->getLoginUser();

        if(request()->isPost()){
            $data = input('post.');
            // 严格校验提交的数据， tp5 validate 小伙伴自行完成，

            $deals = [
                'business_id' => $user->business_id,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'city_id' => $data['city_id'],
                'shop_id' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_start_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'note' => $data['notes'],
                'description' => $data['description'],
                'business_user_id' => $user->id,
            ];
            $product = new ProductService();
            $new = $product->create($deals);
            if($new) {
                $this->success('添加成功', url('product/index'));
            }else {
                $this->error('添加失败');
            }
        }else{
            $city = new CityService();
            $citys = $city->all(array('level' => 1), array('cityCode' => 'asc'));
            $this->assign('citys', $citys);

            $catigory = new CategoryService();
            $catigorys = $catigory->getSelectOption();
            $this->assign('categorys', $catigorys);

            $shop = new ShopService();
            $shops = $shop->all(array('uid' => $user->id, 'status' => 2), null, "id, name");
            $this->assign('shops', $shops);
        }
        return $this->fetch();
    }
}