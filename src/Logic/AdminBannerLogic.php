<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/18
 * Time: 16:37
 */

namespace Logic;

use Exception\BannerException;
use Exception\BaseException;
use Exception\ClassException;
use Model\BannerModel;
use Model\ClassModel;

class AdminBannerLogic extends BaseLogic
{

    /**
     * 后台获取banner列表
     * @return array
     */
    public function listBanner()
    {
        $banner = BannerModel::listBanner();

        return $banner;
    }

    public function addBanner($img_url, $url, $status = 1, $sort = 0)
    {
        $data = [
            "img_url" => $img_url,
            "url" => $url,
            "status" => $status,
            "sort" => $sort,
        ];
        $banner = BannerModel::addBanner($data);

        return $banner;
    }

    public function deleteBanner($banner_id)
    {
        return BannerModel::deleteBanner($banner_id);
    }

    public function updateBanner($banner_id,$img_url,$url,$status,$sort)
    {
        $data = [
            "img_url" => $img_url,
            "url" => $url,
            "status" => $status,
            "sort" => $sort
        ];
        $where = ["id"=>$banner_id];
        return BannerModel::updateBanner($where,$data);
    }

    /**
     * 后台获取单个banner
     * @param $id
     * @return bool|mixed
     */
    public function getBanner($id)
    {
        $result = BannerModel::getBanner($id);

        if(empty($result)){
            BannerException::BannerNotFound();
        }

        return $result;
    }


}