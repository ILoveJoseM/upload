<?php
/**
 * @author xiaoyongbiao
 * @email 781028081@qq.com
 * Date: 2017/8/29
 */

namespace Model;

use Exception\BaseException;
use FastD\Model\Model;

class UserModel extends Model
{
    const USER_TABLE = "db_user";

    public static function getUser($uid)
    {
        $user = database()->get(self::USER_TABLE,"*",[
            "id" => $uid
        ]);

        return $user;
    }

    public static function addUser($data)
    {
        $data['create_time'] = time();
        $user = database()->insert(self::USER_TABLE,$data);

        if(!$user){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function getUserByOpenId($openid)
    {
        $user = database()->get(self::USER_TABLE,"*",[
            "openid" => $openid
        ]);

        return $user;
    }

    public static function listUser($where = [])
    {
        return database()->select(self::USER_TABLE,"*",$where);
    }

    public static function countUser($where = [])
    {
        return database()->count(self::USER_TABLE,[],$where);
    }

    public static function getUserByUnionId($unionid)
    {
        $user = database()->get(self::USER_TABLE,"*",[
            "unionid" => $unionid
        ]);

        return $user;
    }

    public static function updateUserByUid($uid, $data)
    {
        return database()->update(self::USER_TABLE, $data, ["id" => $uid]);
    }
}