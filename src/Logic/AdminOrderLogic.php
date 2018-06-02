<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/25
 * Time: 15:16
 */

namespace Logic;


use Model\OrderModel;

class AdminOrderLogic extends BaseLogic
{
    public function listOrder($key = '',$value = '',$page = 1,$row = 10)
    {
        $page = $page<1?1:$page;

        $row = $row<1?1:$row;

        $first_row = ($page-1)*$row;
        $where = ["o.status[>=]" => 1];

        if(!empty($value)&&!empty($key))
        {
            $where["{$key}[~]"] = "%{$value}%";
        }

        $count = OrderModel::countOrder($where);

        $total_page = floor($count/$row)+1;

        $where["ORDER"] = ["o.pay_time"=>"DESC"];
        $where["LIMIT"] = [$first_row,$row];

        $result_list = OrderModel::listOrder($where);
        $result['list'] = $result_list;
        $result['total_page'] = $total_page;
        $result['total_count'] = $count;
        $result['row_num'] = $row;

        return $result;
    }
}