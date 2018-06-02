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

class AdminLogin extends Middleware
{

    public function handle(ServerRequestInterface $request, DelegateInterface $next)
    {

        if (isset($_SESSION['admin_id'])&&!empty($_SESSION['admin_id'])) {
            $response = $next($request);
        } else {

            $response =  new ApiResponse(
                ErrorCode::msg(ErrorCode::USER_NOT_LOGIN),
                ErrorCode::USER_NOT_LOGIN,
                [],
                ErrorCode::status(ErrorCode::USER_NOT_LOGIN)
            );
        }

        return $response;
    }
}