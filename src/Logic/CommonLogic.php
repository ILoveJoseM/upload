<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 14:59
 */

namespace Logic;

use Component\Wxapp\Wxapp;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use Exception\OrderException;
use Exception\UserException;
use Model\BuyModel;
use Model\ClassModel;
use Model\OrderModel;
use Model\UserModel;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Service\SessionService;

class CommonLogic extends BaseLogic
{
    public function login()
    {
        $log = myLog("login");
        $log->addDebug("开始授权获取用户信息");
        $oauth = wechat()->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        $log->addDebug("用户对象：".serialize($user));

        $wechat_user = $user->toArray();
        $log->addDebug("授权对象：".json_encode($wechat_user));
        $scope = $user['token']['scope'];
        $openid = $wechat_user['id'];
        if($scope=="snsapi_userinfo")
        {
            $userInfo = $wechat_user['original'];
            $data = [
                "openid" => $userInfo['openid'],
                "subscribe" => 1,
                "nickname" => $userInfo['nickname'],
                "sex" => $userInfo['sex'],
                "language" => $userInfo['language'],
                "city" => $userInfo['city'],
                "country" => $userInfo['country'],
                "province" => $userInfo['province'],
                "headimgurl"=> $userInfo['headimgurl'],
                "subscribe_time" => time(),
                "unionid" => isset($userInfo['unionid'])?$userInfo['unionid']:"",
                "remark" => "",
                "groupid" => "",
                "channel_id" => isset($_SESSION['channel'])?$_SESSION['channel']:1,
                "openid_type" => 0,
            ];
        }else{
            $userService = wechat()->user;
            $userInfo = $userService->get($openid);
            $data = [
                "openid" => $userInfo->openid,
                "subscribe" => $userInfo->subscribe,
                "nickname" => $userInfo->nickname?:"微信用户".time(),
                "sex" => $userInfo->sex?:0,
                "language" => $userInfo->language?:"未知",
                "city" => $userInfo->city?:"未知",
                "country" => $userInfo->coutry?:"未知",
                "province" => $userInfo->province?:"未知",
                "headimgurl"=> $userInfo->headimgurl?:"http://www.ym8800.com/static/img/preson.f518f1a.png",
                "subscribe_time" => $userInfo->subscribe_time?:time(),
                "unionid" => $userInfo->unionid?:"",
                "remark" => $userInfo->remark?:"",
                "groupid" => $userInfo->groupid?:"",
                "channel_id" => isset($_SESSION['channel'])?$_SESSION['channel']:1,
                "openid_type" => 0,
            ];
        }
        $log->addDebug("用户信息：".json_encode($data));
        $_SESSION['userInfo'] = $data;
        $my_user = UserModel::getUserByOpenId($data['openid']);

        if(!$my_user)
        {
            $my_user['id'] = UserModel::addUser($data);
        }
        $_SESSION["uid"] = $my_user['id'];
        if($my_user['id']){
            return [];
        }else{
            UserException::LoginFail();
        }

//        $targetUrl = empty($_SESSION['redirect_url']) ? '/' : $_SESSION['redirect_url'];
//        header('location:'. $targetUrl); // 跳转到原来的页面
//        exit;
    }

    /**
     * 支付回调
     * @param \EasyWeChat\Support\Collection $notify
     * @param $successful
     * @return bool
     */
    public static function orderNotify($notify,$successful)
    {
        $log = new Logger('orderNotify');
        $log_path = app()->getPath()."/runtime/logs";
        $log->pushHandler(new StreamHandler($log_path.'/orderNotify.log',Logger::DEBUG));
        $log->addDebug("开始支付回调");
        $log->addDebug("支付回调对象：".serialize($notify));
        $log->addDebug("回调结果：".$successful);
//        $json = '{"appid":"wx85ba94e795ed698e","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1493544892","nonce_str":"5a28b176d48ef","openid":"ogI3N053qFInk5ygBo8DtuTyIfFY","out_trade_no":"15126163108678","result_code":"SUCCESS","return_code":"SUCCESS","sign":"ED2102B4731E138DA271268C1A6C0857","time_end":"20171207111157","total_fee":"1","trade_type":"JSAPI","transaction_id":"4200000014201712079614286793"}';
//        $notify = json_decode($json);
        $notify = $notify->toArray();
        $order_id = $notify['out_trade_no'];
        $order = OrderModel::getOrderById($order_id);
        $log->addDebug("取得订单：".json_encode($order));
        if(!$order)
        {
            return 'Order not exist.';
        }

        if($order['status']!==0)
        {
            return true;
        }

        if($successful){
            $order_data = [
                "settlement_total_fee" => $notify['total_fee']/100,
                "fee_type" => $notify['fee_type'],
                "coupon_fee" => isset($notify['coupon_fee'])?$notify['coupon_fee']/100:0,
                "transaction_id" => $notify['transaction_id'],
                "bank_type" => $notify['bank_type'],
                "pay_time" => strtotime($notify['time_end']),
                "status" => 1
            ];

            database()->pdo->beginTransaction();
            $order_result = OrderModel::updateOrder($order_data,["order_id"=>$order_id]);
            $user_class = BuyModel::getUserClassByOrderId($order_id, ['class_id']);
            $class = ClassModel::getClass($user_class['class_id']);
            $buy_result = BuyModel::buySuccess($order_id, $class['expire_month']);
            $log->addDebug("order_result：".$order_result);
            $log->addDebug("buy_result：".$buy_result);
            if($order_result&&$buy_result){
                database()->pdo->commit();
            }else{
                database()->pdo->rollBack();
            }
        }

        $log->addDebug("回调数组：".json_encode($notify));

        return true;
    }

    /**
     * 微信统一下单
     * @param $data
     * @return array|string
     */
    public function createOrder($data, $paysource = 0)
    {
        $log = new Logger('createOrder');
        $log_path = app()->getPath()."/runtime/logs";
        $log->pushHandler(new StreamHandler($log_path.'/createOrder.log',Logger::DEBUG));
        $log->addDebug("开始微信统一下单");
        $log->addDebug("统一下单参数：".json_encode($data));

        $order = new Order($data);

        if($paysource == 0){
            $payment = wechat()->payment;
        }else{
            $app_id = config()->get("wxapp_app_id");
            $app_secret = config()->get("wxapp_app_secret");
            //小程序支付
            $payment = (new Application([
                'app_id'  => $app_id,
                'secret'  => $app_secret,
                'payment' => [
                    'merchant_id'        => '1493544892',
                    'key'                => '2yaoyuan1367890POIMNBHYTSGBHJK67',
                    'notify_url'         => 'http://www.ym8800.com/common/order_notify',      // XXX: 绝对路径！！！！
                ],
            ]))->payment;
        }


        $result = $payment->prepare($order);
        $log->addDebug("统一下单结果：".$result->return_code);
        $log->addDebug("统一下单结果2：".$result->result_code);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;

            $config = $payment->configForJSSDKPayment($prepayId);

            return $config;
        }else{
            OrderException::OrderCreateFail();
        }
    }

    public function getJssdk($url,array $APIs)
    {
        $js = wechat()->js;

        $js->setUrl($url);

        $config = $js->config($APIs);

        return $config;
    }

    public function wxappLogin($code)
    {
        $log = myLog("wxapp_login");
//
        $log->addDebug("开始请求");
        $app_id = config()->get("wxapp_app_id");
        $app_secret = config()->get("wxapp_app_secret");
        $log->addDebug("code:".$code);
        $log->addDebug("app_id:".$app_id);
        $log->addDebug("app_secret".$app_secret);
        $wechat = new Wxapp($app_id,$app_secret);

        if(empty($code)){
            UserException::LoginFail();
        }
        $result = $wechat->login($code);
        $log->addDebug("login_result:".json_encode($result));
        if(!isset($result['openid']))
        {
            UserException::LoginFail();
        }

        /**
         * @var SessionService;
         */
        $session = app()->get("session");

        $session->setId($result['3rd_session']);

        $session->start();
        if(!isset($result['unionid'])||empty($result['unionid'])||!$user = UserModel::getUserByUnionId($result['unionid'])){
            $data = [
                "openid" => $result['openid'],
                "unionid" => isset($result['unionid'])?$result['unionid']:"",
                "openid_type" => 1,
            ];
            $log->addDebug("用户信息：".json_encode($data));
            $_SESSION['userInfo'] = $data;
            $my_user = UserModel::getUserByOpenId($data['openid']);
            $log->addDebug("数据库的用户信息：".json_encode($my_user));
            if(!$my_user)
            {
                $my_user['id'] = UserModel::addUser($data);
            }
            $log->addDebug("入库结果：".$my_user['id']);
            $_SESSION["uid"] = $my_user['id'];
            if($my_user['id']){
                return ["session_id" => $result['3rd_session']];
            }else{
                UserException::LoginFail();
            }
        }else{
            $_SESSION['uid'] = $user['id'];
        }

        return ["session_id" => $result['3rd_session']];
    }

    public function updateUser($params)
    {
        $uid = $_SESSION['uid'];
        return UserModel::updateUserByUid($uid,$params);
    }
}