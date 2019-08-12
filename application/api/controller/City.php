<?php

namespace app\api\controller;

use app\common\service\CityService;
use think\Controller;
use think\Request;

class City extends BusinessBase
{
    /**
     * @param $parent_id
     * 获取下级城市
     */
    public function sub($parent_id){
        $objCity = new CityService();
        $citys = $objCity->all(array('parent_id' => $parent_id), array('cityCode' => 'asc'));
        $data = [];
        foreach($citys as $city){
            $data[] = ['id' => $city->id, 'name' => $city->item];
        }
        $this->runtSuccess('获取成功', $data);
    }
    /**
     * 显示资源列表
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
