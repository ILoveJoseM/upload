<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 22:48
 */

namespace Model;

use Exception\BaseException;

class ArticleModel
{
    const ARTICLE_TABLE = "db_article";

    public static function getArticle($id)
    {
        $result = database()->get(self::ARTICLE_TABLE,"*",[
            "id" => $id
        ]);

        return $result;
    }

    public static function addArticle($data)
    {
        $data['create_time'] = time();
        $article = database()->insert(self::ARTICLE_TABLE,$data);

        if(!$article){
            BaseException::SystemError();
        }
        return database()->id();
    }

    public static function listArticle($where = [])
    {
        $db = database();

        $result = $db->select(self::ARTICLE_TABLE,"*",
            $where
        );

        return $result;
    }

    public static function updateArticle($where = [],$data = [])
    {
        $data['update_time'] = time();
        $db = database();

        $result = $db->update(self::ARTICLE_TABLE,$data,
            $where
        );

        return $result;
    }

    public static function deleteArticle()
    {

    }
}