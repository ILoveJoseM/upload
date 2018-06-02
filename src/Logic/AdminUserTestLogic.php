<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/29
 * Time: 14:28
 */

namespace Logic;


use Model\AttendTestModel;

class AdminUserTestLogic extends BaseLogic
{
    public function listUserTest($page = 1,$row = 10)
    {
        $page = $page<1?1:$page;

        $row = $row<1?1:$row;

        $first_row = ($page-1)*$row;
        $where = [];

        $count = AttendTestModel::countUserTest($where);

        $total_page = floor($count/$row)+1;

        $where["ORDER"] = ["id"=>"DESC"];
        $where["LIMIT"] = [$first_row,$row];

        $result_list = AttendTestModel::listAttend($where);
        $result['list'] = $result_list;
        $result['total_page'] = $total_page;
        $result['total_count'] = $count;
        $result['row_num'] = $row;

        return $result;
    }
}