<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 23:28
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminClassTryLogic;
use Service\ApiResponse;

class AdminClassTryController extends BaseController
{
    /**
     * @name 后台获取课程试听列表
     * @apiParam class_id|int|课程ID|true
     * @returnParam [].id|int|课程ID
     * @returnParam [].resource_type|int|资源类型，0-视频 1-文章
     * @returnParam [].sort|int|试听列表排序 大的在前
     * @returnParam [].title|int|试听列表排序 大的在前
     * @returnParam [].desc|int|试听列表排序 大的在前
     * @returnParam [].img_url|int|试听列表排序 大的在前
     * @returnParam [].resource.id|int|资源ID
     * @returnParam [].resource.media_url|string|视频地址， resource_type=0时存在
     * @returnParam [].resource.media_time|int|视频长度， resource_type=0时存在
     * @returnParam [].resource.size|int|视频大小，单位：byte， resource_type=0时存在
     * @returnParam [].resource.title|string|文章标题，resource_type=1时存在
     * @returnParam [].resource.img_url|string|文章图片地址，resource_type=1时存在
     * @returnParam [].resource.content|string|文章内容，resource_type=1时存在
     * @param ServerRequest $request
     * @return ApiResponse;
     */
    public function listTry(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        return $this->response(AdminClassTryLogic::getInstance()->listTry($class_id));
    }

    /**
     * @name 新增课程试听
     * @apiParam class_id|int|课程ID|true
     * @apiParam img_url|string|试听图片|true
     * @apiParam resource_type|int|试听类型 0-视频 1-文章|true
     * @apiParam title|string|试听标题|true
     * @apiParam desc|string|试听内容|true
     * @apiParam sort|int|试听排序|true
     * @apiParam resource_data.resource_id|string|视频资源ID|false
     * @apiParam resource_data.title|string|文章标题|false
     * @apiParam resource_data.img_url|string|文章图片|false
     * @apiParam resource_data.content|string|文章内容|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addTry(ServerRequest $request)
    {

        $class_id = $request->getParam("class_id");
        $resource_type = $request->getParam("resource_type");
        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $img_url = $request->getParam("img_url");
        $sort = $request->getParam("sort");

        $resource_data = $request->getParam("resource_data");

        $result = AdminClassTryLogic::getInstance()->addTry($class_id,$resource_type,$title,$desc,$img_url,$resource_data,$sort);
        if($result)
        {
            return $this->response([]);
        }

    }

    /**
     * @name 删除试听
     * @apiParam id|int|试听ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteTry(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response([AdminClassTryLogic::getInstance()->deleteTry($id)]);
    }
}