<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/4
 * Time: 20:41
 */

/**
 * @return Service\RedisService;
 */
function redis()
{
    return app()->get("redis");
}

/**
 * @return \EasyWeChat\Foundation\Application;
 */
function wechat()
{
    return app()->get("wechat");
}

/**
 * @return \Upload\Storage\FileSystem;
 */
function upload()
{
    return app()->get("uploader");
}

function myLog($filename = "debug", $level = \Monolog\Logger::DEBUG)
{
    $log = new \Monolog\Logger($filename);
    $log_path = app()->getPath()."/runtime/logs/";
    $max_file = config()->get("log_limit", 0);
    $is_log = config()->get("is_log", true);
    $log->pushHandler(new \Monolog\Handler\RotatingFileHandler($log_path.$filename, $max_file, $level));
    if(!$is_log){
        $log->pushHandler(new \Monolog\Handler\NullHandler($level));
    }
    return $log;
}
