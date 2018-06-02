<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 15:55
 */

namespace Logic;


use Exception\ClassException;
use Model\ClassModel;

class AdminClassLogic extends BaseLogic
{
    /**
     * 后台获取课程列表
     * @param int $page
     * @param int $row
     * @return array
     */
    public function listClass($page = 1,$row = 20)
    {

        $page = $page<1?1:$page;

        $row = $row<1?1:$row;

        $first_row = ($page-1)*$row;

        $count = ClassModel::countClass();

        $total_page = floor($count/$row)+1;

        $where["ORDER"] = ["id"=>"DESC"];
        $where["LIMIT"] = [$first_row,$row];

        $class_list = ClassModel::listClass();
        $class['list'] = $class_list;
        $class['total_page'] = $total_page;
        $class['current_page'] = $page;

        return $class;
    }

    /**
     * 后台增加课程
     * @param $title
     * @param $desc
     * @param $tag
     * @param $img_url
     * @param $price
     * @param $sold
     * @param $status
     * @return int|string
     */
    public function addClass($title,$desc,$tag,$img_url,$price,$sold,$status = 1,$expire_month = 0)
    {
        $data = [
            "title"     => $title,
            "desc"      => $desc,
            "tag"       => $tag,
            "img_url"   => $img_url,
            "price"     => $price,
            "sold"      => $sold,
            "status"    => $status,
            "expire_month"    => $expire_month,
        ];

        return ClassModel::addClass($data);
    }

    /**
     * 后台获取单个课程
     * @param $class_id
     * @return bool|mixed
     */
    public function getClass($class_id)
    {
        $class = ClassModel::getClass($class_id);

        if(empty($class)){
            ClassException::ClassNotFound();
        }

        return $class;
    }

    public function updateClass($class_id,$title,$desc,$tag,$img_url,$price,$sold,$status = 1,$expire_month = 0)
    {
        $data = [
            "title"     => $title,
            "desc"      => $desc,
            "tag"       => $tag,
            "img_url"   => $img_url,
            "price"     => $price,
            "sold"      => $sold,
            "status"    => $status,
            "expire_month"    => $expire_month
        ];
        $where = ["id"=>$class_id];
        return ClassModel::updateClass($where,$data);
    }

    public function deleteClass($class_id)
    {
        return ClassModel::deleteClass($class_id);
    }
}