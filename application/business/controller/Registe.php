<?php
namespace app\business\controller;

use app\common\controller\Base;
use app\common\model\BusinessUser;
use app\common\service\BusinessService;
use app\common\service\BusinessUserService;
use app\common\service\CategoryService;
use app\common\service\CityService;
use app\common\service\ShopService;
use app\common\service\UserService;
use app\common\validate\BusinessValidate;
use think\Db;
use think\Exception;

class Registe extends Base
{
    public function index()
    {
        $city = new CityService();
        $citys = $city->all(array('level' => 1), array('cityCode' => 'asc'));
        $this->assign('citys', $citys);

        $catigory = new CategoryService();
        $catigorys = $catigory->getSelectOption();
        $this->assign('categorys', $catigorys);
        return $this->fetch();
    }

    public function add()
    {
        $businessData = [
            'name' => input('name'),
            'email' => input('email'),
            'logo' => input('logo'),
            'licence_logo' => input('licence_logo'),
            'description' => input('description'),
            'city_id' => input('city_id'),
            'city_path' => input('city_id') . "," . input('se_city_id'),
            'bank_info' => input('bank_info'),
            'bank_name' => input('bank_name'),
            'bank_user' => input('bank_user'),
            'legal_user' => input('faren'),
            'legal_tel' => input('faren_tel'),
            'category_id' => input('category_id'),
        ];


        $businessValidate = new BusinessValidate();
        if($businessValidate->check($businessData)){
            unset($businessData['category_id']);

            $category = new CategoryService();
            $oneCategory = $category->one(input('category_id'));

            $address = input('address');
            $shopData = [
                'name' => $businessData['name'],
                'logo' => $businessData['logo'],
                'address' => input('address'),
                'tel' => input('tel'),
                'contact' => input('contact'),
                'business_id' => input(''),
                'open_time' => input('open_time'),
                'description' => input('content'),
                'is_main' => 1,
                'bank_info' => $businessData['bank_info'],
                'city_id' => $businessData['city_id'],
                'city_path' => $businessData['city_path'],
                'category_id' => input('category_id'),
                'category_path' => $oneCategory->parent_path,
            ];

            Db::startTrans();

            try{

                $business = new BusinessService();
                $newBusiness = $business->create($businessData);


                $shopData['business_id'] = $newBusiness->id;
                if($address){
                    $map = \Bmap::getGeoCode($address);
                    if($map){
                        $shopData['xpoint'] = $map['location']['lat'];
                        $shopData['ypoint'] = $map['location']['lng'];
                    }
                }


                $salt = runt_create_salt();
                $pw = runt_hash_password(input('password'), $salt);
                $dataUser = array(
                    'username' => input('username'),
                    'password' => $pw,
                    'pw_salt' => $salt,
                    'business_id' => $newBusiness->id
                );
                $user = new BusinessUser();
                $newUser = $user->create($dataUser);
                if(!empty($newUser)){


                    $shopData['uid'] = $newUser->id;
                    $shop = new ShopService();
                    $shop->create($shopData);


                    Db::commit();
                    $this->redirect(url('business/login/index'));
                }

                Db::rollback();
                return $this->runtError('创建失败，请联系系统管理员');
            }catch(Exception $e){
                Db::rollback();
                return $this->runtError($e->getMessage());
            }
        }else{
            return $this->runtError($businessValidate->getError());
        }
    }
}