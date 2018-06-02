<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 18:20
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\AdminCommonLogic;
use Logic\UploadLogic;

class AdminCommonController extends BaseController
{
    /**
     * @name 上传图片
     * @apiParam upload|file|文件|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function uploadImage(ServerRequest $request)
    {
        return $this->response(["path"=>UploadLogic::getInstance()->uploadImage()]);
    }

    /**
     * @name 上传视频
     * @apiParam upload|file|文件|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function uploadVideo(ServerRequest $request)
    {
        $time = $request->getParam("media_time",0);
        list($path,$resource_id) = UploadLogic::getInstance()->uploadVideo("file",$time);
        return $this->response(["path"=>$path,"resource_id"=>$resource_id]);
    }
}