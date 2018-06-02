<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/25
 * Time: 11:06
 */

namespace Controller;


use Exception\BaseException;
use FastD\Http\ServerRequest;
use Logic\AdminClassChapterLogic;

class AdminClassChapterController extends BaseController
{
    /**
     * @name 后台获取章节
     * @apiParam class_id|int|课程ID|true
     * @returnParam [].id|int|章节ID
     * @returnParam [].title|string|标题
     * @returnParam [].chapter_no|int|章节数
     * @returnParam [].desc|string|章节描述
     * @return \Service\ApiResponse
     */
    public function listChapter(ServerRequest $request)
    {
        $class_id = $request->getParam("class_id");
        return $this->response(AdminClassChapterLogic::getInstance()->listChapter($class_id));
    }

    /**
     * @name 新增章节
     * @apiParam title|string|章节标题|true
     * @apiParam chapter_no|string|章节数|true
     * @apiParam class_id|int|课程ID|true
     * @apiParam desc|string|章节描述|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addChapter(ServerRequest $request)
    {
        $title = $request->getParam("title");
        $chapter_no = $request->getParam("chapter_no","");
        $class_id = $request->getParam("class_id",1);
        $desc = $request->getParam("desc",1);
        $result = AdminClassChapterLogic::getInstance()->addChapter($title,$chapter_no,$class_id,$desc);
        if($result)
        {
            return $this->response([]);
        }else{
            BaseException::SystemError();
        }

    }

    /**
     * @name 更新章节
     * @apiParam id|int|章节ID|true
     * @apiParam title|string|章节标题|true
     * @apiParam chapter_no|int|章节数|true
     * @apiParam class_id|int|课程ID|true
     * @apiParam desc|string|章节描述|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateChapter(ServerRequest $request)
    {
        $id = $request->getParam("id");
        $title = $request->getParam("title");
        $chapter_no = $request->getParam("chapter_no");
        $class_id = $request->getParam("class_id",1);
        $desc = $request->getParam("desc",1);
        $result = AdminClassChapterLogic::getInstance()->updateChapter($id,$title,$chapter_no,$class_id,$desc);
        if($result)
        {
            return $this->response([]);
        }else{
            BaseException::SystemError();
        }
    }

    /**
     * @name 删除章节
     * @apiParam id|int|章节ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteChapter(ServerRequest $request)
    {
        $id = $request->getParam("id");
        return $this->response([AdminClassChapterLogic::getInstance()->deleteChapter($id)]);
    }
}