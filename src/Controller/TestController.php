<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 15:10
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\TestLogic;

class TestController extends BaseController
{
    /**
     * @name 获取测试
     * @apiParam id|int|测试ID|true
     * @returnParam id|int|测试ID
     * @returnParam title|string|测试标题
     * @returnParam star|int|星星数
     * @returnParam img_url|string|图片地址
     * @returnParam test_num|int|测试人数
     * @returnParam desc|string|描述
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getTest(ServerRequest $request)
    {
        $test_id = $request->getParam("id");
        return $this->response(TestLogic::getInstance()->getTest($test_id));
    }

    /**
     * @name 获取测试的问题
     * @apiParam test_id|int|测试ID|true
     * @returnParam [].img_url|string|图片地址
     * @returnParam [].desc|string|问题描述
     * @returnParam [].option[].desc|string|选项描述
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getAsk(ServerRequest $request)
    {
        $test_id = $request->getParam("test_id");

        return $this->response(TestLogic::getInstance()->getAskList($test_id));
    }

    /**
     * @name 随机获取一个答案
     * @apiParam test_id|int|测试ID|true
     * @returnParam img_url|string|图片地址
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function randAnswer(ServerRequest $request)
    {
        $test_id = $request->getParam("test_id");
        $user_id = $_SESSION['uid'];
        $channel_id = $request->getParam("channel_id",1);
        return $this->response(TestLogic::getInstance()->randAnswer($user_id,$test_id,$channel_id));
    }
}