<?php
namespace app\common\validate;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/14
 * Time: 21:07
 */
class BusinessValidate extends Validate
{
    protected $rule = [
        'name' => 'require',
        'email' => 'require|email',
        'city_id' => 'require',
        'category_id' => 'require',
    ];

    protected $message = [
        'name.require' => '商户名称必填',
        'email.require' => '邮箱必填',
        'email.email' => '邮箱格式错误',
        'city_id.require' => '所属分类必选',
        'category_id.require' => '所属分类必选'
    ];
}