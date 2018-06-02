<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/21
 * Time: 23:55
 */

namespace Controller;

use FastD\Http\ServerRequest;
use Logic\CommonLogic;
use Logic\UploadLogic;
use Service\Uploader;

class CommonController extends BaseController
{

    /**
     * @name 登录回调
     * @apiParam code|string|微信登录code|true
     * @apiParam state|string|开发者自定义参数|false
     * @return \Service\ApiResponse
     */
    public function login(ServerRequest $request)
    {
        return $this->response(CommonLogic::getInstance()->login());
    }

    /**
     * @name 支付回调
     * @return \Service\ApiResponse
     */
    public function notifyOrder()
    {
        $payment = wechat()->payment;
        $response = $payment->handleNotify("\Logic\CommonLogic::orderNotify");
        $response->send();
    }

    /**
     * @name 微信jssdk
     * @apiParam url|string|调用地址|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function wechatJssdk(ServerRequest $request)
    {
        $url = $request->getParam("url");
        return $this->response(CommonLogic::getInstance()->getJssdk($url,[
            "onMenuShareTimeline",
            "onMenuShareAppMessage",
            "onMenuShareQQ",
            "onMenuShareWeibo",
            "onMenuShareQZone",
        ]));
    }

    public function wxappLogin(ServerRequest $request)
    {

        $params = json_decode($request->getBody()->getContents(),true);
        $code = $params['code'];

        return $this->response(CommonLogic::getInstance()->wxappLogin($code));
    }

    public function updateUser(ServerRequest $request)
    {
        $params = json_decode($request->getBody()->getContents(),true);
        $data = [
            "headimgurl" => $params['avatarUrl'],
            "country" => $params['country'],
            "province" => $params['province'],
            "city" => $params['city'],
            "language" => $params['language'],
            "nickname" => $params['nickName'],
            "sex" => $params['gender']
        ];
        return $this->response(CommonLogic::getInstance()->updateUser($data));
    }
}