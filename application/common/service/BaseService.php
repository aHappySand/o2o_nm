<?php
namespace app\common\service;

class BaseService
{
    public $model = '';

    public function one($where, $field = '*', $orderBy = '')
    {
        return $this->model->findOne($where, $field, $orderBy);
    }

    public function delete($where)
    {
        return $this->model->deleteSome($where);
    }

    public function some($where)
    {
        return $this->model->where($where)->all();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function saveAll($data)
    {
        return $this->model->saveAll($data);
    }

    public function add($data)
    {
        return $this->model->save($data);
    }

    public function edit($data, $where)
    {
        return $this->model->save($data, $where);
    }

    /**
     * 更新字段公共方法
     * @param $model
     * @param $data
     * @return mixed
     */
    protected function updateFieldSortById($data)
    {
        return $this->model->isUpdate()->saveAll($data);
    }

    public function page($where = '', $order = '', $limit = '', $field = '*', array $hidden = [])
    {
        if (empty($order)) {
            $order = $this->model->getPk() . ' desc';
        }
        $res = $this->model->field($field)->where($where)->order($order)->paginate($limit);
        if (!empty($hidden)) {
            return $res->hidden($hidden);
        }
        return $res;
    }

    public function count($where)
    {
        return $this->model->where($where)->count();
    }

    public function sum($where, $field)
    {
        return $this->model->where($where)->sum($field);
    }
} 