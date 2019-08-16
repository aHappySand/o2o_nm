<?php
/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/14
 * Time: 22:55
 */

namespace app\common\command;

use think\console\Command;
use think\Db;
use think\Console;

use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class DicPath extends Command
{
    protected function configure()
    {
        $this->setName('db:dicpath')
            ->addArgument('dicname', Argument::OPTIONAL, "字典表名")
            ->setDescription('字典父级path');
    }

    protected function execute(Input $input, Output $output)
    {
        $name = trim($input->getArgument('dicname'));
        $output->writeln($name);

        $tables = explode(',', $name);

        foreach($tables as $table){
            $arr = array();
            $this->genArr($table, $arr);

            $arrPath = array();
            $this->genPath($arr, $arrPath);

            foreach($arrPath as $id => $path){
                Db::table($table)->where('id', $id)->update(array('parent_path' => trim($path, ',')));
            }
        }
        $output->writeln('success');

    }

    private function genArr($table, &$data, $parent_id = 0){
        $all = Db::table($table)->where(array('parent_id' => $parent_id))
            ->order(array('weight' => 'asc', 'parent_id' => 'asc'))
            ->select();

        foreach($all as $category) {
            $data[$category['id']] = array(
                'parent_id' => $category['parent_Id'],
                'item' => $category['item']
            );
            $data[$category['id']]['children'] = array();
            $this->genArr($table, $data[$category['id']]['children'], $category['id']);
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