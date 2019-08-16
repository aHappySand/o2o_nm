<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/13
 * Time: 22:16
 */

namespace app\api\controller;

class Image extends BusinessBase
{
    public function upload(){
        $file = input('file.file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload'. DS . 'image');
            if($info){
                return $this->runtSuccess('上传成功', array('url' => DS . 'upload'. DS . 'image'.DS .$info->getSaveName() ));
            }else{
                // 上传失败获取错误信息
                return $this->runtError('上传失败');
            }
        }
        return $this->runtError('上传失败');
    }
}