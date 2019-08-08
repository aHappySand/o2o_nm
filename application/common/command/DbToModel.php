<?php

/**
 * Created by PhpStorm.
 * User: zjj
 * Date: 2019/8/7
 * Time: 23:08
 */

namespace app\common\command;

use think\console\Command;
use think\Db;
use think\Config;
use think\Console;

use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class DbToModel extends Command
{
    protected function configure()
    {
        $this->setName('db:model')
            ->addArgument('mod', Argument::OPTIONAL, "模块名")
            ->setDescription('根据表创建模块');
    }

    protected function execute(Input $input, Output $output)
    {
        $name = trim($input->getArgument('mod'));

        $sql = "show tables";
        $re = Db::query($sql);
        $d = Config::get('database')['database'];
        $s = 'Tables_in_' . $d;
        //转换为索引数组
        $data = [];
        foreach ($re as $index => $item) {
            $r=strpos($item[$s],'fa_basic');
//            if($r !== false){
                $table = $item[$s];
                $arrTb = explode("_", $table);
                $arrTb = array_map(function($v){
                    return ucfirst($v);
                }, $arrTb);
                $table = implode("", $arrTb);
                $cmd = 'make:model ' . $name."/" . $table;
                $output->writeln($cmd);
                Console::call('make:model', array("mod" => $name."/" . $table));
                Console::call('make:controller', array("mod" => "api/" . $table));
                Console::call('make:controller', array("mod" => "admin/" . $table));
                Console::call('make:controller', array("mod" => "index/" . $table));
//            }
        }
    }
}