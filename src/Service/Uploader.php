<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 23:47
 */

namespace Service;

use Exception\BaseException;
use Upload\File;
use Upload\Validation\Mimetype;

class Uploader
{
    public static function save($file_form_name,$mine_type = [])
    {
        $uploader = upload();

        $file = new File($file_form_name, $uploader);

        $resource_id = md5_file($file->getFileInfo());

        $file->setName($resource_id);

        if(count($mine_type)>0){
            $file->addValidations(new Mimetype($mine_type));
        }

        try
        {
            if ($file->upload()) {
                return $file;
            }
        }catch(\Exception $e)
        {
            if($e->getMessage()=="File already exists")
            {
                return $file;
            }else{
                BaseException::UploadError($e);
            }
        }
    }
}