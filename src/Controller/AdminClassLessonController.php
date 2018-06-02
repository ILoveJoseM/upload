<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 23:28
 */

namespace Controller;


use FastD\Http\ServerRequest;
use Logic\AdminClassLessonLogic;
use Logic\AdminClassTryLogic;
use Service\ApiResponse;

class AdminClassLessonController extends BaseController
{
    /**
     * @name 后台获取章节课时列表
     * @apiParam chapter_id|int|课程ID|true
     * @returnParam [].id|int|课程ID
     * @returnParam [].chapter_id|int|章节ID
     * @returnParam [].title|string|标题
     * @returnParam [].desc|string|描述
     * @returnParam [].resource_type|string|课程标题
     * @returnParam [].lesson_no|string|第几课
     * @returnParam [].img_url|string|课的图片
     * @returnParam [].resource.media_time|int|视频长度，单位：秒， resource_type=0时存在
     * @returnParam [].resource.title|string|文章标题，resource_type=1时存在
     * @returnParam [].resource.img_url|string|文章图片地址，resource_type=1时存在
     * @param ServerRequest $request
     * @return ApiResponse;
     */
    public function listLesson(ServerRequest $request)
    {
        $id = $request->getParam("chapter_id");
        return $this->response(AdminClassLessonLogic::getInstance()->listLesson($id));
    }

    /**
     * @name 新增章节的课
     * @apiParam chapter_id|int|章节ID|true
     * @apiParam title|string|标题|true
     * @apiParam desc|string|描述|true
     * @apiParam resource_type|int|类型|true
     * @apiParam lesson_no|int|第几课|true
     * @apiParam img_url|string|课的图片|true
     * @apiParam resource_data.resource_id|string|视频资源ID|false
     * @apiParam resource_data.title|string|文章标题|false
     * @apiParam resource_data.img_url|string|文章图片|false
     * @apiParam resource_data.content|string|文章内容|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addLesson(ServerRequest $request)
    {

        $chapter_id = $request->getParam("chapter_id");
        $resource_type = $request->getParam("resource_type");
        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $img_url = $request->getParam("img_url");
        $lesson_no = $request->getParam("lesson_no","");

        $resource_data = $request->getParam("resource_data");
//        var_dump($resource_data);exit;

        $result = AdminClassLessonLogic::getInstance()->addLesson($chapter_id,$resource_type,$title,$desc,$img_url,$lesson_no,$resource_data);
        if($result)
        {
            return $this->response([]);
        }

    }

    /**
     * @name 删除课
     * @apiParam id|int|课ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteLesson(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response([AdminClassLessonLogic::getInstance()->deleteLesson($id)]);
    }

    /**
     * @name 更新章节的课
     * @apiParam id|int|课的ID|true
     * @apiParam title|string|标题|true
     * @apiParam desc|string|描述|true
     * @apiParam lesson_no|int|第几课|true
     * @apiParam img_url|string|课的图片|true
     * @apiParam resource_data.resource_id|string|视频资源ID|false
     * @apiParam resource_data.id|int|文章资源唯一ID|false
     * @apiParam resource_data.title|string|文章标题|false
     * @apiParam resource_data.img_url|string|文章图片|false
     * @apiParam resource_data.content|string|文章内容|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateLesson(ServerRequest $request)
    {
        $id = $request->getParam("id");
        $title = $request->getParam("title");
        $desc = $request->getParam("desc");
        $img_url = $request->getParam("img_url");
        $lesson_no = $request->getParam("lesson_no");
        $resource_data = $request->getParam("resource_data");

        return $this->response(AdminClassLessonLogic::getInstance()->updateLesson($id, $title, $desc, $img_url, $lesson_no, $resource_data));
    }
}