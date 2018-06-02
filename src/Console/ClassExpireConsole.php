<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/2/3
 * Time: 15:11
 */

namespace Console;


use EasyWeChat\Core\Exception;
use Model\BuyModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClassExpireConsole extends Command
{

    public function configure()
    {
        $this->setName('yd:class_expire')
            ->setDescription('课程过期处理');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        //更新过期时间不为0，小于当前时间且状态为1的课程，状态值更新为2
        try{
            BuyModel::updateUserClass(
                [
                    "AND"=>[
                        "end_time[<]" => time(),
                        "end_time[!]" => 0,
                        "status" => 1,
                    ]
                ],
                [
                    "status" => 2,
                ]
            );
        }catch (Exception $exception){
            print_r($exception->getTraceAsString());
        }
    }
}