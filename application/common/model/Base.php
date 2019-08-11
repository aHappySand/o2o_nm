<?php
/**
 * Base.php
 *
 * @data 19/6/8
 * @author Henry <8323216@qq.com>
 * @link http://www.hisun360.com/
 * @copyright Copyright© 2012 - 2015 HISUN. All Rights Reserved.
 */

namespace app\common\model;


use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp = true;

    public function getCreateTimeFullAttr($value, $data)
    {
        return time_to_full($data['create_time']);
    }

    public function getCreateTimeDayAttr($value, $data)
    {
        return time_to_day($data['create_time']);
    }

    public function findOne($where, $field = "*", $orderBy = '')
    {
        if (is_numeric($where)) {
            return $this->field($field)->order($orderBy)->find($where);
        }
        return $this->field($field)->where($where)->order($orderBy)->find();
    }

    public function findSome($where, $limit = 20, $field = "*", $orderBy = '')
    {
        return $this->field($field)->where($where)->limit($limit)->order($orderBy)->select();
    }

    public function findAll($where = [], $field = "*", $orderBy = '', $limit = '10000')
    {
        return $this->field($field)->where($where)->limit($limit)->order($orderBy)->select();
    }
    public function deleteSome($where)
    {
        if (is_numeric($where)) {
            $where = $this->getPk() . '=' . $where;
        }
        return $this->where($where)->delete(true);
    }
} 