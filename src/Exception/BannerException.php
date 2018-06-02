<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/26
 * Time: 19:33
 */

namespace Exception;

use Constant\ErrorCode;

class BannerException extends BaseException
{
    public static function BannerNotFound()
    {
        throw new self(
            ErrorCode::msg(ErrorCode::BANNER_NOT_FOUND),
            ErrorCode::BANNER_NOT_FOUND
        );
    }
}