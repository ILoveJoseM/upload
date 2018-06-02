<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 15:58
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminClassLogic;
use Service\ApiResponse;

class AdminClassController extends BaseController
{
    /**
     * @name 后台获取课程列表
     * @apiParam page|int|分页页数，默认为1|false
     * @returnParam list[].id|int|课程ID
     * @returnParam list[].sold|int|卖出数量
     * @returnParam list[].price|float|售价
     * @returnParam list[].img_url|string|图片地址
     * @returnParam list[].title|string|课程标题
     * @returnParam list[].tag|string|课程标签
     * @returnParam list[].desc|string|课程描述
     * @returnParam list[].expire_month|int|过期时间，单位：月
     * @returnParam current_page|int|当前页数
     * @returnParam total_page|string|总页数
     * @param ServerRequest $request
     * @return ApiResponse;
     */
    public function listClass(ServerRequest $request)
    {
        $page = $request->getParam("page",1);
        return $this->response(AdminClassLogic::getInstance()->listClass($page));
    }

    /**
     * @name 增加一个课程
     * @apiParam title|string|课程标题|true
     * @apiParam desc|string|课程描述|true
     * @apiParam tag|string|课程标签|true
     * @apiParam img_url|string|课程图片|true
     * @apiParam price|float|课程价格|true
     * @apiParam sold|int|课程卖出|true
     * @apiParam status|int|课程卖出|true
     * @apiParam expire_month|int|课程过期时间，单位：月，0为不过期|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addClass(ServerRequest $request)
    {

        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $tag = $request->getParam("tag");
        $img_url = $request->getParam("img_url");
        $price = $request->getParam("price");
        $sold = $request->getParam("sold");
        $status = $request->getParam("status",1);
        $expire_month = $request->getParam("expire_month",0);

        $class = AdminClassLogic::getInstance()->addClass($title,$desc,$tag,$img_url,$price,$sold,$status,$expire_month);
        if($class)
        {
            return $this->response([]);
        }

    }

    /**
     * @name 后台获取问题详情
     * @apiParam class_id|int|课程ID|true
     * @returnParam id|int|课程ID
     * @returnParam sold|int|卖出数量
     * @returnParam img_url|string|图片地址
     * @returnParam price|float|价格
     * @returnParam title|string|标题
     * @returnParam status|int|状态1-可用 0-不可用
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");

        return $this->response(AdminClassLogic::getInstance()->getClass($class_id));
    }

    /**
     * @name 更新一个课程
     * @apiParam class_id|int|课程ID|true
     * @apiParam title|string|课程标题|true
     * @apiParam desc|string|课程描述|true
     * @apiParam tag|string|课程标签|true
     * @apiParam img_url|string|课程图片|true
     * @apiParam price|float|课程价格|true
     * @apiParam sold|int|课程卖出|true
     * @apiParam status|int|课程状态|true
     * @apiParam expire_month|int|课程过期时间，单位：月，0为不过期|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse;
     */
    public function updateClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $tag = $request->getParam("tag");
        $img_url = $request->getParam("img_url");
        $price = $request->getParam("price");
        $sold = $request->getParam("sold");
        $status = $request->getParam("status",1);
        $expire_month = $request->getParam("expire_month",0);

        return $this->response(AdminClassLogic::getInstance()->updateClass(
            $class_id,
            $title,
            $desc,
            $tag,
            $img_url,
            $price,
            $sold,
            $status,
            $expire_month
        ));
    }

    /**
     * @name 冻结课程
     * @apiParam class_id|int|课程ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteClass(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        return $this->response([AdminClassLogic::getInstance()->deleteClass($class_id)]);
    }
}