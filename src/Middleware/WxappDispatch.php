<?php
namespace Middleware;

use Constant\ErrorCode;
use Exception\BaseException;
use FastD\Middleware\DelegateInterface;
use FastD\Middleware\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Service\ApiResponse;

class WxappDispatch extends Middleware
{

    public function handle(ServerRequestInterface $request, DelegateInterface $next)
    {
        try {
            $response = $next($request);
        } catch (\Exception $e) {

            $response = new ApiResponse(
                $e->getMessage(),
                $e->getCode(),
                null,
                ErrorCode::status($e->getCode())
            );
//            if($e->getCode()!==0){
//                $response = new ApiResponse(
//                    $e->getMessage(),
//                    $e->getCode(),
//                    null,
//                    ErrorCode::status($e->getCode())
//                );
//            }else{
//                BaseException::SystemError();
//            }
        }

        return $response;
    }
}