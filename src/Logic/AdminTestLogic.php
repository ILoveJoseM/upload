<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 14:36
 */

namespace Logic;


use Exception\BaseException;
use Model\TestModel;

class AdminTestLogic extends BaseLogic
{
    public function listTest()
    {
        $result = TestModel::listTest();

        return $result;
    }

    public function addTest($title,$star,$img_url,$test_num,$desc)
    {
        $data = [
            "img_url" => $img_url,
            "title" => $title,
            "star" => $star,
            "test_num" => $test_num,
            "desc" => $desc,
        ];
        $result = TestModel::addTest($data);

        return $result;
    }

    public function deleteTest($id)
    {
        return TestModel::deleteTest($id);
    }

    public function updateTest($id,$title,$star,$img_url,$test_num,$desc)
    {
        $data = [
            "img_url" => $img_url,
            "title" => $title,
            "star" => $star,
            "test_num" => $test_num,
            "desc" => $desc,
        ];
        $where = ["id"=>$id];
        return TestModel::updateTest($data,$where);
    }

    public function listAsk($test_id)
    {

        $where = ["test_id" => $test_id];
        $result = TestModel::listAsk($where);

        if(!$result){
            return [];
        }

        $ask_ids = [];
        $ask_index = [];
        foreach ($result as $v)
        {
            $ask_ids[] = $v['id'];
            $ask_index[$v['id']] = $v;
        }

        $option_where = ["ask_id"=>$ask_ids];

        $options = TestModel::listOption($option_where);

        foreach ($options as $option)
        {
            $ask_index[$option['ask_id']]['option'][] = $option;
        }

        return array_values($ask_index);

    }

    public function addAsk($test_id,$img_url,$desc,$options,$ask_no = 0)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id,
            "desc" => $desc,
        ];
        if(!$ask_no)
        {
            $ask_no = TestModel::getMaxAskNo($test_id);
            $data['ask_no'] = (int)$ask_no + 1;
        }else{
            $data['ask_no'] = $ask_no;
        }

        database()->pdo->beginTransaction();

        $ask_id = TestModel::addAsk($data);
        if(!$ask_id)
        {
            database()->pdo->rollBack();
            BaseException::SystemError();
        }

        foreach ($options as $k => $option)
        {
            $options[$k]['ask_id'] = $ask_id;
        }
        $result1 = TestModel::addOption($options);
        if($result1)
        {
            database()->pdo->commit();
            return true;
        }else{
            database()->pdo->rollBack();
            BaseException::SystemError();
        }
    }

    public function deleteAsk($id)
    {
        return TestModel::deleteAsk($id);
    }

    public function updateAsk($id,$test_id,$img_url,$desc,$options,$ask_no = 0)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id,
            "desc" => $desc,
        ];
        if($ask_no)
        {
            $data['ask_no'] = $ask_no;
        }
        database()->pdo->beginTransaction();
        foreach ($options as $option)
        {
            if(isset($option['id'])&&!empty($option['id'])){
                $result1 = TestModel::updateOption($option,["id"=>$option['id']]);
            }else{
                $result1 = TestModel::addOption($option);
            }
            if(!$result1)
            {
                database()->pdo->rollBack();
                BaseException::SystemError();
            }
        }
        $where = ["id"=>$id];
        $result = TestModel::updateAsk($data,$where);
        if($result){
            database()->pdo->commit();
            return true;
        }else{
            database()->pdo->rollBack();
            BaseException::SystemError();
        }
    }

    public function listAnswer($test_id)
    {
        $where = ["test_id" => $test_id];
        $result = TestModel::listAnswer($where);

        return $result;
    }

    public function addAnswer($test_id,$img_url)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id
        ];
        $result = TestModel::addAnswer($data);

        return $result;
    }

    public function deleteAnswer($id)
    {
        return TestModel::deleteAnswer($id);
    }

    public function updateAnswer($id,$test_id,$img_url)
    {
        $data = [
            "img_url" => $img_url,
            "test_id" => $test_id
        ];
        $where = ["id"=>$id];
        return TestModel::updateAnswer($data,$where);
    }

    public function deleteOption($id)
    {
        return TestModel::deleteOption($id);
    }

}