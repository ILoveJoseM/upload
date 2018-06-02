<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/22
 * Time: 19:28
 */

namespace Logic;

use Model\MediaModel;
use Service\Uploader;

class UploadLogic extends BaseLogic
{
    public function uploadImage($name = "file")
    {
        $file = Uploader::save($name,[
            "image/png",
            "image/jpeg",
            "image/gif",
            "image/bmp"
        ]);

        $path = "https://a.ym8800.com".app()->get("config")->get("upload_dir")."/".$file->getName().".".$file->getExtension();

        $data = [
            "resource_id" => $file->getName(),
            "img_url" => $path,
            "mime_type" => $_FILES[$name]['type'],
            "size" => $_FILES[$name]['size'],
        ];
        $resource = MediaModel::getImageByResourceId($data['resource_id']);
        if(!$resource){
            $id = MediaModel::addImage($data);
        }
        return $path;
    }

    public function uploadVideo($name = "file",$time = 0)
    {
        $file = Uploader::save($name,["video/mpeg","video/mp4"]);

        $path = "https://a.ym8800.com".app()->get("config")->get("upload_dir")."/".$file->getName().".".$file->getExtension();

        $data = [
            "resource_id" => $file->getName(),
            "media_url" => $path,
            "mime_type" => $_FILES[$name]['type'],
            "size" => $_FILES[$name]['size'],
            "media_time" => $time
        ];
        $resource = MediaModel::getVideoByResourceId($data['resource_id']);
        if(!$resource){
            $id = MediaModel::addMedia($data);
        }
        return [$path,$data['resource_id']];
    }
}