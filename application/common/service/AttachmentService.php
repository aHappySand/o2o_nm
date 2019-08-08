<?php
namespace app\common\service;


use app\common\model\Attachment;

class AttachmentService extends BaseService
{
    /**
     * 添加一条附件数据获取附件id
     *
     * @param $data
     * @return mixed
     */
    public function addAttachment($data)
    {
        $attachment = Attachment::create($data);
        return $attachment->id;
    }

    /**
     * 根据id查找某一个附件
     *
     * @param $id
     * @return mixed
     */
    public function getAttachmentOne($id)
    {
        return Attachment::get($id);
    }

    /**
     * 根据id删除一条数据以及文件
     *
     * @param $id
     * @param bool $isDelFile
     */
    public function delAttachmentOne($id, $isDelFile = false)
    {
        Attachment::destroy($id);
        if ($isDelFile) {
            //todo 删除服务器文件
        }
    }
}