<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/14
 * Time: 21:28
 */

namespace app\common\validate;


use think\Validate;

class ShopValidate extends Validate
{
    protected $rule = [
        'name' => 'require',
        'tel' => 'require',
        'contact' => 'require',
        'address' => 'require',
    ];

    protected $message = [
        'name.require' => '商户名称必填',
        'tel.require' => '电话必填',
        'contact.require' => '联系人必填',
        'address.require' => '商户地址必填',
    ];
}