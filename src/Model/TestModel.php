<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 10:17
 */

namespace Model;


use Exception\BaseException;

class TestModel extends BaseModel
{
    const TEST_TABLE = "db_test";
    const ASK_TABLE = "db_test_ask";
    const ANSWER_TABLE = "db_test_answer";
    const OPTION_TABLE = "db_test_ask_option";

    public static function getTest($id)
    {
        $db = database();

        $result = $db->get(self::TEST_TABLE,"*",["id"=>$id]);

        return $result;
    }

    public static function listTest($where = [])
    {
        $db = database();

        $result = $db->select(self::TEST_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function addTest($data)
    {
        $result = database()->insert(self::TEST_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function deleteTest($id)
    {
        $db = database();

        $where['id'] = $id;
        $result = $db->delete(self::TEST_TABLE,
            $where
        );

        return $result;
    }

    public static function updateTest($data = [],$where = [])
    {
        $db = database();

        $result = $db->update(self::TEST_TABLE,$data,
            $where
        );

        return $result;
    }

    public static function listAsk($where = [])
    {
        $db = database();

        $result = $db->select(self::ASK_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function addAsk($data)
    {
        $result = database()->insert(self::ASK_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function deleteAsk($id)
    {
        $db = database();

        $where['id'] = $id;
        $result = $db->delete(self::ASK_TABLE,
            $where
        );

        return $result;
    }

    public static function updateAsk($data = [],$where = [])
    {
        $db = database();

        $result = $db->update(self::ASK_TABLE,$data,
            $where
        );

        if($result===false){
            return false;
        }else{
            return true;
        }
    }

    public static function getMaxAskNo($test_id)
    {
        $db = database();

        $where = ["test_id" => $test_id];

        return $db->max(self::ASK_TABLE,"ask_no",$where);

    }

    public static function listOption($where = [])
    {
        $db = database();

        $result = $db->select(self::OPTION_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function addOption($data)
    {
        $result = database()->insert(self::OPTION_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function deleteOption($id)
    {
        $db = database();

        $where['id'] = $id;
        $result = $db->delete(self::OPTION_TABLE,
            $where
        );

        return $result;
    }

    public static function updateOption($data = [],$where = [])
    {
        $db = database();

        $result = $db->update(self::OPTION_TABLE,$data,
            $where
        );

        if($result===false){
            return false;
        }else{
            return true;
        }
    }

    public static function listAnswer($where = [])
    {
        $db = database();

        $result = $db->select(self::ANSWER_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function addAnswer($data)
    {
        $result = database()->insert(self::ANSWER_TABLE,$data);

        if(!$result){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function deleteAnswer($id)
    {
        $db = database();

        $where['id'] = $id;
        $result = $db->delete(self::ANSWER_TABLE,
            $where
        );

        return $result;
    }

    public static function updateAnswer($data = [],$where = [])
    {
        $db = database();

        $result = $db->update(self::ANSWER_TABLE,$data,
            $where
        );

        return $result;
    }
}