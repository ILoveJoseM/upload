<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/28
 * Time: 14:46
 */

namespace Exception;

use Constant\ErrorCode;

class TestException extends BaseException
{
    public static function TestNotFound()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::TEST_NOT_FOUND),
            ErrorCode::TEST_NOT_FOUND
        );
    }
}