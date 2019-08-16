<?php

namespace app\common\service;

use app\common\model\Category;

class CategoryService extends BaseService
{
    public function __construct()
    {
        $this->model = new Category();
    }

    public function getSelectOption(){
        $data = array();
        $this->genArr($data);
        $options = array();
//        $this->genPath($data, $options);
//        print_r($options);exit;

        $this->genOption($data, $options);
        return $options;
    }

    private function genArr(&$data, $parent_id = 0){
        $all = $this->model->where(array('status' => 1, 'parent_id' => $parent_id))
            ->order(array('weight' => 'asc', 'parent_id' => 'asc'))
            ->select();
        foreach($all as $category) {
            $data[$category->id] = array(
                'parent_id' => $category->parent_id,
                'item' => $category->item
            );
            $data[$category->id]['children'] = array();
            $this->genArr($data[$category->id]['children'], $category->id);
        }
    }

    private function genOption($oldData, &$newData, $index = 0){
        foreach($oldData as $id => $item){
            $newData[$id] = str_repeat('---', $index) . $item['item'];
            if(isset($item['children']) && count($item['children'])>0){
                $this->genOption($item['children'], $newData, $index + 1);
            }
        }
    }

    private function genPath($oldData, &$newData, $parent_id=""){
        foreach($oldData as $id => $item){
            $newData[$id] = $parent_id ? $parent_id."," : "";
            if(isset($item['children']) && count($item['children'])>0){
                $this->genPath($item['children'], $newData, $newData[$id] . $id);
            }
        }
    }
}
