<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/11/24
 * Time: 22:31
 */

namespace Logic;


use EasyWeChat\Message\Article;
use Exception\BaseException;
use Exception\ClassException;
use Model\ArticleModel;
use Model\ClassModel;
use Model\MediaModel;

class AdminClassLessonLogic extends BaseLogic
{
    /**
     * 后台获取课程试听列表
     * @param int $chapter_id
     * @param int $page
     * @param int $row
     * @return array
     */
    public function listLesson($chapter_id,$page = 1,$row = 20)
    {

        $where['chapter_id'] = $chapter_id;
        $result_list = ClassModel::listChapterLesson($where);

        if(count($result_list)<1)
        {
            $result['list'] = [];

            return $result;
//            ClassException::NoLessonInChapter();
        }

        $resource_id = [];
        foreach ($result_list as $v)
        {
            $resource_id[] = $v['resource_id'];
        }

        $resource_id = array_unique($resource_id);

        $article = ArticleModel::listArticle(["id"=>$resource_id]);
        $article_index = [];
        foreach ($article as $k=>$v)
        {
            $article_index[$v['id']] = $v;
        }

        $media = MediaModel::listMedia(["id"=>$resource_id]);
        $media_index = [];
        foreach ($media as $k=>$v)
        {
            $media_index[$v['id']] = $v;
        }

        foreach ($result_list as $k=>$v)
        {
            if($v['resource_type']==0)
            {
                $result_list[$k]['resource'] = $media_index[$v['resource_id']];
            }else{
                $result_list[$k]['resource'] = $article_index[$v['resource_id']];
            }
        }

        $result['list'] = $result_list;

        return $result;
    }

    /**
     * @param $chapter_id
     * @param $resource_type
     * @param $title
     * @param $desc
     * @param $img_url
     * @param array $resource_data
     * @param int $lesson_no
     * @return int|string
     */
    public function addLesson($chapter_id,$resource_type,$title,$desc,$img_url,$lesson_no,$resource_data = [] )
    {
        if(empty($lesson_no)){
            $lesson_no = ClassModel::getMaxLesson($chapter_id)+1;
        }
        $data = [
            "chapter_id"  => $chapter_id,
            "resource_type" => $resource_type,
            "title"     => $title,
            "desc"      => $desc,
            "lesson_no" => $lesson_no,
            "img_url"   => $img_url,
        ];

        $count = ClassModel::countLesson(["chapter_id" => $chapter_id,"lesson_no" => $lesson_no,]);

        if($count>0){
            ClassException::LessonDuplicate();
        }

        //开启事务
        database()->pdo->beginTransaction();
        if($resource_type ==0)
        {
            $result = MediaModel::getVideoByResourceId($resource_data['resource_id']);
            MediaModel::updateVideoMediaTime($resource_data['resource_id'],$resource_data['media_time']);
            if($result){
                $data['resource_id'] = $result["id"];
            }else{
                BaseException::VideoNotFound();
            }
        }else{
            $rdata['title'] = $resource_data['title'];
            $rdata['img_url'] = $resource_data['img_url'];
            $rdata['content'] = $resource_data['content'];
            $data['resource_id'] = ArticleModel::addArticle($rdata);
        }

        if($result = ClassModel::addLesson($data))
        {
            database()->pdo->commit();
            return $result;
        }else{
            database()->pdo->rollBack();
            BaseException::SystemError();
        }

    }

    public function deleteLesson($id)
    {
        return ClassModel::deleteLesson($id);
    }

    public function updateLesson($id,$title,$desc,$img_url,$lesson_no,$resource_data = [])
    {
        //获取课的类型
        $lesson = ClassModel::getLesson($id, ['resource_type','resource_id']);
        $resource_type = $lesson['resource_type'];
        $data = [
            "title"     => $title,
            "desc"      => $desc,
            "lesson_no" => $lesson_no,
            "img_url"   => $img_url,
        ];

        //开启事务
        database()->pdo->beginTransaction();
        if($resource_type ==0)
        {
            $result = MediaModel::getVideoByResourceId($resource_data['resource_id']);
            MediaModel::updateVideoMediaTime($resource_data['resource_id'],$resource_data['media_time']);
            if($result){
                $data['resource_id'] = $result["id"];
            }else{
                BaseException::VideoNotFound();
            }
        }else{
            $rdata['title'] = $resource_data['title'];
            $rdata['img_url'] = $resource_data['img_url'];
            $rdata['content'] = $resource_data['content'];
            ArticleModel::updateArticle(['id' => $resource_data['id']], $resource_data);
            $data['resource_id'] = $resource_data['id'];
        }

        if($result = ClassModel::updateLesson(['id' => $id],$data))
        {
            database()->pdo->commit();
            return $result;
        }else{
            database()->pdo->rollBack();
            BaseException::SystemError();
        }
    }
}