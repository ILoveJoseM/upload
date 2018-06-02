<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/16
 * Time: 23:40
 */

namespace ServiceProvider;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use Upload\Storage\FileSystem;

class UploadServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // TODO: Implement register() method.
        $dirctory = app()->getPath().app()->get("config")->get('upload_dir');
        $container->add("uploader",new FileSystem($dirctory));
    }
}