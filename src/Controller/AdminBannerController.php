<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 16:44
 */

namespace Controller;

use Exception\BaseException;
use FastD\Http\ServerRequest;
use Logic\AdminBannerLogic;
use Model\BannerModel;

class AdminBannerController extends BaseController
{

    /**
     * @name 后台获取banner
     * @returnParam [].id|int|bannerID
     * @returnParam [].img_url|string|图片url
     * @returnParam [].url|string|跳转链接
     * @returnParam [].sort|int|排序
     * @return \Service\ApiResponse
     */
    public function listBanner()
    {
        return $this->response(AdminBannerLogic::getInstance()->listBanner());
    }

    /**
     * @name 新增banner
     * @apiParam img_url|string|图片地址|true
     * @apiParam url|string|跳转地址|false
     * @apiParam status|int|状态0-冻结 1-可用，默认为1|false
     * @apiParam sort|int|状态0-冻结 1-可用，默认为1|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function addBanner(ServerRequest $request)
    {
        $img_url = $request->getParam("img_url");
        $url = $request->getParam("url","");
        $status = $request->getParam("status",1);
        $sort = $request->getParam("sort",0);
        $banner = AdminBannerLogic::getInstance()->addBanner($img_url,$url,$status,$sort);
        if($banner)
        {
            return $this->response([]);
        }else{
            BaseException::SystemError();
        }

    }

    /**
     * @name 更新banner
     * @apiParam banner_id|int|banner的ID|true
     * @apiParam img_url|string|图片地址|true
     * @apiParam url|string|跳转地址|false
     * @apiParam status|int|状态0-冻结 1-可用，默认为1|false
     * @apiParam sort|int|排序小的在前|false
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function updateBanner(ServerRequest $request)
    {
        $banner_id = $request->getParam("banner_id");
        $img_url = $request->getParam("img_url");
        $url = $request->getParam("url","");
        $status = $request->getParam("status",1);
        $sort = $request->getParam("sort",0);
        $result = AdminBannerLogic::getInstance()->updateBanner($banner_id,$img_url,$url,$status,$sort);
        if($result)
        {
            return $this->response([]);
        }else{
            BaseException::SystemError();
        }
    }

    /**
     * @name 冻结banner
     * @apiParam banner_id|int|banner的ID|true
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function deleteBanner(ServerRequest $request)
    {
        $banner_id = $request->getParam("banner_id");
        return $this->response([AdminBannerLogic::getInstance()->deleteBanner($banner_id)]);
    }

    /**
     * @name 后台banner详情
     * @apiParam banner_id|int|bannerID|true
     * @returnParam id|int|课程ID
     * @returnParam sold|int|卖出数量
     * @returnParam img_url|string|图片地址
     * @returnParam price|float|价格
     * @returnParam title|string|标题
     * @returnParam status|int|状态1-可用 0-不可用
     * @param ServerRequest $request
     * @return \Service\ApiResponse
     */
    public function getBanner(ServerRequest $request)
    {
        $id = $request->getParam("banner_id");

        return $this->response(AdminBannerLogic::getInstance()->getBanner($id));
    }


}