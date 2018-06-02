<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/26
 * Time: 22:14
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminIncomeStaticLogic;

class AdminIncomeStaticController extends BaseController
{

    /**
     * @name 获取最近一周的收入
     * @returnParam sum|float|平台总收入
     * @returnParam list[].pay_date|string|支付日期
     * @returnParam list[].income|float|当天收入
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function incomeStatic(ServerRequest $request)
    {
        return $this->response(AdminIncomeStaticLogic::getInstance()->incomeStatic());
    }

}