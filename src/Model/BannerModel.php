<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:50
 */

namespace Model;

use Exception\BaseException;

class BannerModel extends BaseModel
{

    const BANNER_TABLE = "db_banner";

    public static function listBanner($where = [])
    {
        $db = database();

        $result = $db->select(self::BANNER_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function addBanner($data)
    {

        $data['create_time'] = time();
        $banner = database()->insert(self::BANNER_TABLE,$data);

        if(!$banner){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function updateBanner($where = [],$data = [])
    {
        $data['update_time'] = time();
        $db = database();

        $result = $db->update(self::BANNER_TABLE,$data,
            $where
        );

        return $result;
    }

    public static function deleteBanner($banner_id)
    {
        $data['update_time'] = time();
        $data['status'] = 0;
        $where["id"] = $banner_id;
        $db = database();

        $result = $db->update(self::BANNER_TABLE,$data,
            $where
        );

        return $result;
    }

    /**
     * 根据banner ID获取课程
     * @param $id
     * @return bool|mixed
     */
    public static function getBanner($id)
    {
        $db = database();

        $result = $db->get(self::BANNER_TABLE,"*",["id"=>$id]);

        return $result;
    }
}