<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/8
 * Time: 15:05
 */

namespace Middleware;

use Constant\ErrorCode;
use FastD\Middleware\DelegateInterface;
use FastD\Middleware\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Service\ApiResponse;

class LoginCheck extends Middleware
{

    public function handle(ServerRequestInterface $request, DelegateInterface $next)
    {
//        session_start();

        $_SESSION['channel'] = isset($_GET['channel'])?$_GET['channel']:isset($_SESSION['channel'])?$_SESSION['channel']:"";

        if (isset($_SESSION['uid'])&&!empty($_SESSION['uid'])) {
            $response = $next($request);
        } else {
//            $wechat = \wechat();

//            $_SESSION['redirect_url'] = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/";

//            $oauth = $wechat->oauth;

            $response =  new ApiResponse(
                ErrorCode::msg(ErrorCode::USER_NOT_LOGIN),
                ErrorCode::USER_NOT_LOGIN,
                [],
                200
            );
        }

        return $response;
    }
}