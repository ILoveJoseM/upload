<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/25
 * Time: 15:14
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminOrderLogic;
use Model\OrderModel;

class AdminOrderController extends BaseController
{
    /**
     * @name 获取订单列表
     * @apiParam key|string|搜索的键名 o.order_id订单号，u.nickname用户名，c.title课程名称，cc.channel_name渠道来源，o.pay_time支付时间|false
     * @apiParam value|string|值|false
     * @returnParam list[].order_id|string|订单号
     * @returnParam list[].user_id|int|用户ID
     * @returnParam list[].nickname|string|用户昵称
     * @returnParam list[].class_id|int|课程ID
     * @returnParam list[].title|string|课程标题
     * @returnParam list[].channel_name|string|渠道名称
     * @returnParam list[].pay_time|int|支付时间戳
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listOrder(ServerRequest $request)
    {
        $key = $request->getParam("key",'');
        $value = $request->getParam("value",'');
        $page = $request->getParam("page",1);
        return $this->response(AdminOrderLogic::getInstance()->listOrder($key,$value,$page,20));
    }
}