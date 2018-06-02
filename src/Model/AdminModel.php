<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 15:52
 */

namespace Model;

class AdminModel extends BaseModel
{
    const ADMIN_TABLE = "db_admin";
    public static function getAdmin($where = [])
    {
        $db = database();

        $result = $db->get(self::ADMIN_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function updateAdmin($where = [],$data = [])
    {
        $db = database();

        $result = $db->update(self::ADMIN_TABLE,$data,
            $where
        );

        return $result;
    }
}