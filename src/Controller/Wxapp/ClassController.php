<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/1/19
 * Time: 16:41
 */

namespace Controller\Wxapp;


use Controller\BaseController;
use Exception\OrderException;
use FastD\Http\ServerRequest;
use Logic\ClassLogic;

class ClassController extends BaseController
{
    /**
     * @name 购买课程
     * @apiParam class_id|int|课程ID|true
     * @apiParam channel|int|渠道ID|true
     * @apiParam paysource|int|支付来源|true
     * @returnParam jsapiConfig.appId|string|公众号appId
     * @returnParam jsapiConfig.nonceStr|string|随机字符串
     * @returnParam jsapiConfig.package|string|微信支付package
     * @returnParam jsapiConfig.paySign|string|签名
     * @returnParam jsapiConfig.signType|string|签名类型
     * @returnParam jsapiConfig.timeStamp|string|时间戳
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function createOrder(ServerRequest $request)
    {
        $params = json_decode($request->getBody()->getContents(),true);
        $class_id = $params['class_id'];
        $channel = isset($params['channel'])?$params['channel']:1;
        $paysource = isset($params['paysource'])?$params['paysource']:1;

        if(!$result = ClassLogic::getInstance()->buyClass($class_id, $channel, $paysource)){
            OrderException::OrderCreateFail();
        }else{
            $result['timeStamp'] = $result['timestamp'];
            unset($result['timestamp']);
            return $this->response(["jsapiConfig"=>json_encode($result)]);
        }
    }

}