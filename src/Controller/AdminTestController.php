<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/29
 * Time: 9:20
 */

namespace Controller;


use FastD\Console\SeedRun;
use FastD\Http\ServerRequest;
use Logic\AdminTestLogic;

class AdminTestController extends BaseController
{
    /**
     * @name 后台获取测试列表
     * @returnParam [].id|int|测试ID
     * @returnParam [].title|string|测试标题
     * @returnParam [].star|int|星星数
     * @returnParam [].img_url|string|图片地址
     * @returnParam [].test_num|int|测试人数
     * @returnParam [].desc|string|描述
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listTest(ServerRequest $request)
    {
        return $this->response(AdminTestLogic::getInstance()->listTest());
    }

    /**
     * @name 后台新增测试
     * @apiParam img_url|string|图片地址|true
     * @apiParam title|string|标题|true
     * @apiParam star|int|星星数|true
     * @apiParam test_num|int|测试人数|true
     * @apiParam desc|string|描述|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addTest(ServerRequest $request)
    {
        $img_url = $request->getParam("img_url");
        $title = $request->getParam("title");
        $star = $request->getParam("star");
        $test_num = $request->getParam("test_num");
        $desc = $request->getParam("desc");

        return $this->response(AdminTestLogic::getInstance()->addTest($title,$star,$img_url,$test_num,$desc));
    }

    /**
     * @name 后台删除测试
     * @apiParam id|int|测试ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteTest(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->deleteTest($id));
    }

    /**
     * @name 后台更新测试
     * @apiParam id|int|测试ID|true
     * @apiParam img_url|string|图片地址|true
     * @apiParam title|string|标题|true
     * @apiParam star|int|星星数|true
     * @apiParam test_num|int|测试人数|true
     * @apiParam desc|string|描述|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateTest(ServerRequest $request)
    {
        $id = $request->getParam("id");
        $img_url = $request->getParam("img_url");
        $title = $request->getParam("title");
        $star = $request->getParam("star");
        $test_num = $request->getParam("test_num");
        $desc = $request->getParam("desc");

        return $this->response(AdminTestLogic::getInstance()->updateTest($id,$title,$star,$img_url,$test_num,$desc));
    }

    /**
     * @name 获取测试的问题
     * @apiParam test_id|int|测试ID|true
     * @returnParam [].id|int|测试问题ID
     * @returnParam [].img_url|string|问题图片地址
     * @returnParam [].test_id|int|测试ID
     * @returnParam [].ask_no|int|问题号
     * @returnParam [].desc|string|问题描述
     * @returnParam [].option[].id|int|选项ID
     * @returnParam [].option[].ask_id|int|问题ID
     * @returnParam [].option[].desc|string|选项描述
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listAsk(ServerRequest $request)
    {

        $test_id = $request->getParam("test_id");

        return $this->response(AdminTestLogic::getInstance()->listAsk($test_id));
    }

    /**
     * @name 后台增加问题
     * @apiParam img_url|string|问题图片地址|true
     * @apiParam test_id|int|测试ID|true
     * @apiParam ask_no|int|问题号|true
     * @apiParam desc|string|问题描述|true
     * @apiParam option[].desc|string|选项描述|true
     * @apiParam option[].sort|int|选项排序，小的在前，默认0|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addAsk(ServerRequest $request)
    {
        $test_id = $request->getParam("test_id");
        $img_url = $request->getParam("img_url");
        $desc = $request->getParam("desc");
        $options = $request->getParam("option");
        $ask_no = $request->getParam("ask_no",0);

        return $this->response(AdminTestLogic::getInstance()->addAsk($test_id,$img_url,$desc,$options,$ask_no));
    }

    /**
     * @name 后台删除问题
     * @apiParam id|int|问题ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteAsk(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->deleteAsk($id));
    }

    /**
     * @name 后台更新问题
     * @apiParam id|int|测试ID|true
     * @apiParam img_url|string|问题图片地址|true
     * @apiParam test_id|int|测试ID|true
     * @apiParam ask_no|int|问题号|true
     * @apiParam desc|string|问题描述|true
     * @apiParam option[].desc|string|选项描述|true
     * @apiParam option[].ask_id|int|问题ID|true
     * @apiParam option[].id|int|描述ID 传的时候更新，不传的时候自动新增|false
     * @apiParam option[].sort|int|选项排序，小的在前，默认0|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateAsk(ServerRequest $request)
    {
        $id = $request->getParam("id");
        $test_id = $request->getParam("test_id");
        $img_url = $request->getParam("img_url");
        $desc = $request->getParam("desc");
        $options = $request->getParam("option");
        $ask_no = $request->getParam("ask_no",0);
        return $this->response(AdminTestLogic::getInstance()->updateAsk($id,$test_id,$img_url,$desc,$options,$ask_no));
    }

    /**
     * @name 后台获取问题的答案
     * @apiParam test_id|int|测试ID|true
     * @returnParam id|int|答案ID
     * @returnParam test_id|int|测试ID
     * @returnParam img_url|string|图片地址
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function listAnswer(ServerRequest $request)
    {
        $test_id = $request->getParam("test_id");

        return $this->response(AdminTestLogic::getInstance()->listAnswer($test_id));
    }

    /**
     * @name 后台增加答案
     * @apiParam test_id|int|测试ID|true
     * @apiParam img_url|string|图片地址|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addAnswer(ServerRequest $request)
    {
        $img_url = $request->getParam("img_url");
        $test_id = $request->getParam("test_id");

        return $this->response(AdminTestLogic::getInstance()->addAnswer($test_id,$img_url));
    }

    /**
     * @name 后台删除答案
     * @apiParam id|int|答案ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteAnswer(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->deleteAnswer($id));
    }

    /**
     * @name 后台更新答案
     * @apiParam id|int|答案ID|true
     * @apiParam test_id|int|测试ID|true
     * @apiParam img_url|string|图片地址|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateAnswer(ServerRequest $request)
    {
        $img_url = $request->getParam("img_url");
        $test_id = $request->getParam("test_id");
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->updateAnswer($id,$test_id,$img_url));
    }

    /**
     * @name 后台删除问题选项
     * @apiParam id|int|选项ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteOption(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response(AdminTestLogic::getInstance()->deleteOption($id));
    }
}