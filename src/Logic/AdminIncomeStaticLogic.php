<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/26
 * Time: 22:13
 */

namespace Logic;


use Model\OrderModel;

class AdminIncomeStaticLogic extends BaseLogic
{
    public function incomeStatic()
    {
        $result = [];

        $result['sum'] = OrderModel::incomeStaticSum();

        $now = time();
        $year_ago = time() - 31536000;

        $result['list'] = OrderModel::dailyIncome($year_ago,$now);

        return $result;
    }
}