<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 22:24
 */

namespace Logic;

use Model\BuyModel;
use Model\UserModel;

class AdminUserLogic extends BaseLogic
{

    public function listUser($nickname = '',$page = 1,$row = 10)
    {
        $page = $page<1?1:$page;

        $row = $row<1?1:$row;

        $first_row = ($page-1)*$row;
        $where = [];

        if(!empty($nickname))
        {
            $where['nickname[~]'] = "%{$nickname}%";
        }

        $count = UserModel::countUser($where);

        $total_page = floor($count/$row)+1;

        $where["ORDER"] = ["id"=>"DESC"];
        $where["LIMIT"] = [$first_row,$row];

        $result_list = UserModel::listUser($where);
        $result['list'] = $result_list;
        $result['total_page'] = $total_page;
        $result['total_count'] = $count;
        $result['row_num'] = $row;

        return $result;
    }
}