<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/1/18
 * Time: 9:33
 */

namespace Controller;


use Component\Wxapp\Wxapp;
use EasyWeChat\Foundation\Application;
use FastD\Http\ServerRequest;

class WechatController
{
    public function wxapp(ServerRequest $request)
    {
        $log = myLog("wxappCustomer");
        $params = $request->getQueryParams();
        $open_id = $params['openid'];
        $body = $request->getBody()->getContents();
        $log->addDebug("params:".json_encode($params));
        $log->addDebug("body:".$body);
        $app_id = config()->get("wxapp_app_id");
        $app_secret = config()->get("wxapp_app_secret");
        $wxapp = new Wxapp($app_id,$app_secret);

        $data = [
            "touser" => $open_id,
            "msgtype" => "link",
            "link" => [
                "title" => "【稳稳收米】欢迎关注夜猫情报局！",
                "description" => "夜猫情报局一直致力于给大家提供迅捷实用的足彩情报 分享足彩技巧干货，帮助大家更稳地收米",
                "url" => "http://mp.weixin.qq.com/s/yfgZZzxVOfwI9a37O7-Uig",
                "thumb_url" => "http://www.ym8800.com/upload/maozhentan.png"
            ]
        ];

        $result = $wxapp->sendCustomerMsg($data);

        $log->addDebug("Result:".$result);


    }
}