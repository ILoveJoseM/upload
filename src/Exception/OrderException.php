<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/19
 * Time: 0:00
 */

namespace Exception;

use Constant\ErrorCode;

class OrderException extends BaseException
{
    public static function OrderCreateFail()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::ORDER_CREATE_FAIL),
            ErrorCode::ORDER_CREATE_FAIL
        );
    }
}