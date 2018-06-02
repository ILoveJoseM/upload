<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 16:57
 */
namespace Logic;

use Exception\BaseException;
use Model\ClassModel;

class AdminClassIntroduceLogic extends BaseLogic
{
    /**
     * 后台获取课程简介
     * @param int $class_id
     * @return array
     */
    public function listIntroduce($class_id)
    {
        $result_list = ClassModel::listClassIntroduce($class_id);
        return $result_list;
    }

    public function addIntroduce($class_id,$data)
    {
        foreach ($data as $k=>$v)
        {
            $data[$k]['create_time'] = time();
            $data[$k]['class_id'] = $class_id;
        }
        return ClassModel::addClassIntroduce($data);
    }

    public function updateIntroduce($list)
    {
        //开启事务
        database()->pdo->beginTransaction();
        foreach ($list as $v)
        {
            if(isset($v['id'])&&!empty($v['id'])){
                $where = ["id"=>$v['id']];
                if(!ClassModel::updateClassIntroduce($where,$v))
                {
                    database()->pdo->rollBack();
                    BaseException::SystemError();
                }
            }else{
                if(!ClassModel::addClassIntroduce($v))
                {
                    database()->pdo->rollBack();
                    BaseException::SystemError();
                }
            }
        }
        database()->pdo->commit();
        return true;
    }

    public function deleteIntroduce($introduce_id)
    {
        return ClassModel::deleteClassIntroduce($introduce_id);
    }
}