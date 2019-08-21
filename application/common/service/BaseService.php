<?php
namespace app\common\service;

class BaseService
{
    public $model = '';

    public function one($where, $field = '*', $orderBy = '')
    {
        return $this->model->findOne($where, $field, $orderBy);
    }

    public function deleteSome($where)
    {
        return $this->model->deleteSome($where);
    }


    /**
     * @param $where
     * @param int $currentPage 当前页码
     * @param int $perPage 每页多少项
     * @return mixed
     */
    public function some($where, $currentPage = 1, $perPage = 10, $order = "")
    {
        return $this->model->where($where)->order($order)->paginate(array(
            'list_rows' => $perPage,
            'page' => $currentPage
        ));
    }

    public function all($where = null, $order = null, $field = "*")
    {
        return $this->model->field($field)->where($where)->order($order)->select();
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

    public function count($where = null)
    {
        return $this->model->where($where)->count();
    }

    public function sum($where, $field = null)
    {
        return $this->model->where($where)->sum($field);
    }
} 