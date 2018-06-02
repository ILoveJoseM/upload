<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/29
 * Time: 14:48
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminUserTestLogic;

class AdminUserTestController extends BaseController
{

    /**
     * @name 后台获取参加测试的用户列表
     * @apiParam page|int|页数|false
     * @returnParam list[].id|int|记录ID
     * @returnParam list[].user_id|int|用户ID
     * @returnParam list[].nickname|string|用户名
     * @returnParam list[].test_id|int|测试ID
     * @returnParam list[].title|string|测试名
     * @returnParam list[].channel_name|string|渠道号
     * @returnParam list[].create_time|int|测试时间戳
     * @returnParam total_page|int|总页数
     * @returnParam total_count|int|总条数
     * @returnParam row_num|int|一页多少行
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listUserTest(ServerRequest $request)
    {
        $page = $request->getParam("page",1);
        return $this->response(AdminUserTestLogic::getInstance()->listUserTest($page));
    }
}