<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/14
 * Time: 23:32
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\ArticleLogic;
use Logic\ClassLogic;
use Logic\AdminUserLogic;

class AdminUserController extends BaseController
{

    /**
     * @name 获取用户列表
     * @apiParam nickname|string|昵称搜索|false
     * @returnParam
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listUser(ServerRequest $request)
    {
        $nickname = $request->getParam("nickname",'');
        $page = $request->getParam("page",1);
        return $this->response(AdminUserLogic::getInstance()->listUser($nickname,$page,20));
    }
}