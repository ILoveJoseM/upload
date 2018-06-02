<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 13:31
 */

namespace Constant;

use FastD\Http\Response;

/**
 * 错误码，除1处理成功，负数的基本错误外，其余错误码均为4位数字，区别于3位的HTTP状态码
 * Class ErrorCode
 * @package Constant
 */

class ErrorCode
{
    const OK = 1;  //处理成功

    const ERR_SYSTEM = -1; //系统错误
    const ERR_INVALID_PARAMETER = -4; //请求参数错误
    const ERR_CHECK_SIGN = -5; //签名验证错误
    const ERR_NO_PARAMETERS = -6; //参数缺失
    const ERR_UNKNOWN = -7; // 未知错误

    /**
     * 10xx用户系统错误
     */
    const USER_NOT_LOGIN = 1000; // 未登录
    const USER_NOT_EXISTS = 1001; // 用户不存在
    const LOGIN_FAIL = 1002; //登录失败

    /**
     * 11xx课程系统错误
     */
    const CLASS_NOT_FOUND = 1100; //课程不存在
    const CLASS_NO_CHAPTER = 1101;//课程没有章节
    const CHAPTER_DUPLICATE = 1102;//课程章节重复
    const LESSON_DUPLICATE = 1103;//章节的课时重复
    const CHAPTER_NO_LESSON = 1104;//章节没有课时
    const CLASS_NO_TRY = 1105;//课程没有试听列表
    const CLASS_EXPIRE = 1106;//课程已过期
    const CLASS_HAS_BOUGHT = 1107;//课程已过期

    /**
     * 12xx订单系统错误
     */
    const ORDER_CREATE_FAIL = 1200;//订单创建失败

    /**
     * 13xxbanner系统错误
     */
    const BANNER_NOT_FOUND = 1300;

    /**
     * 14xx测试系统错误
     */
    const TEST_NOT_FOUND = 1400;

    /**
     * 99xx通用系统错误
     */
    const UPLOAD_FAIL = 9900;//上传失败
    const UNABLE_MIME_TYPE = 9901;//文件格式不支持
    const VIDEO_NOT_FOUND = 9902;//文件格式不支持

    /**
     * 错误代码与消息的对应数组
     *
     * @var array
     */
    static public $msg = [
        self::OK                    => ['处理成功', Response::HTTP_OK],
        self::ERR_SYSTEM            => ['系统错误', Response::HTTP_INTERNAL_SERVER_ERROR],
        self::ERR_INVALID_PARAMETER => ['请求参数错误', Response::HTTP_BAD_REQUEST],
        self::ERR_CHECK_SIGN        => ['签名错误', Response::HTTP_FORBIDDEN],
        self::ERR_NO_PARAMETERS     => ['参数缺失', Response::HTTP_BAD_REQUEST],

        //用户系统错误
        self::USER_NOT_LOGIN        => ['未登录', Response::HTTP_FORBIDDEN],
        self::USER_NOT_EXISTS       => ['用户名或密码错误', Response::HTTP_FORBIDDEN],
        self::LOGIN_FAIL            => ['登录失败', Response::HTTP_BAD_GATEWAY],

        //课程系统错误
        self::CLASS_NOT_FOUND       => ['课程不存在', Response::HTTP_NOT_FOUND],
        self::CLASS_NO_CHAPTER      => ['该课程没有章节', Response::HTTP_NOT_FOUND],
        self::CHAPTER_DUPLICATE      => ['课程章节不能重复', Response::HTTP_BAD_GATEWAY],
        self::LESSON_DUPLICATE      => ['章节课时不能重复', Response::HTTP_BAD_GATEWAY],
        self::CHAPTER_NO_LESSON      => ['该章节没有课时', Response::HTTP_NOT_FOUND],
        self::CLASS_NO_TRY          =>  ['该章节没有试听', Response::HTTP_NOT_FOUND],
        self::CLASS_EXPIRE          =>  ['您购买的课程已过期，请重新购买', Response::HTTP_FORBIDDEN],
        self::CLASS_HAS_BOUGHT      =>  ['您已购买此课程', Response::HTTP_OK],

        //订单系统错误
        self::ORDER_CREATE_FAIL     => ['生成订单失败', Response::HTTP_BAD_GATEWAY],

        //banner系统错误
        self::BANNER_NOT_FOUND      => ['banner不存在', Response::HTTP_NOT_FOUND],

        //测试系统错误
        self::TEST_NOT_FOUND        => ['测试不存在', Response::HTTP_NOT_FOUND],
        //其他错误
        self::UPLOAD_FAIL           => ['上传失败', Response::HTTP_BAD_GATEWAY],
        self::UNABLE_MIME_TYPE      => ['文件格式不支持', Response::HTTP_FORBIDDEN],
        self::VIDEO_NOT_FOUND      =>  ['视频资源不存在', Response::HTTP_NOT_FOUND],
    ];

    /**
     * 返回错误代码的描述信息
     *
     * @param int    $code        错误代码
     * @param string $otherErrMsg 其他错误时的错误描述
     * @return string 错误代码的描述信息
     */
    public static function msg($code, $otherErrMsg = '')
    {
        if ($code == self::ERR_UNKNOWN) {
            return $otherErrMsg;
        }

        if (isset(self::$msg[$code][0])) {
            return self::$msg[$code][0];
        }

        return $otherErrMsg;
    }

    /**
     * 返回错误代码的Http状态码
     * @param int $code
     * @param int $default
     * @return int
     */
    public static function status($code, $default = 200)
    {
        if ($code == self::ERR_UNKNOWN) {
            return $default;
        }

        if (isset(self::$msg[$code][1])) {
            return self::$msg[$code][1];
        }

        return $default;
    }

}

