<?php

//route()->group("/banner",function(){
//    route()->get("/list","BannerController@listBanner");
//});
//
//route()->group(['prefix' => '/user', 'middleware' => 'dispatch'],function(){
//    route()->get("/login","UserController@login");
//    route()->get("/class","UserController@listUserClass");
//    route()->get("/chapter","UserController@getClassChapter");
//    route()->get("/article","UserController@getArticle");
//});
//
//route()->group(['prefix' => '/admin', 'middleware' => 'dispatch'],function(){
//    route()->post("/login","AdminController@login");
//    route()->post("/class/add","ClassController@addClass");
//    route()->delete("/class/delete","ClassController@deleteClass");
//    route()->put("/class/update","ClassController@updateClass");
//    route()->post("/banner/add","BannerController@addBanner");
//    route()->put("/banner/update","BannerController@updateBanner");
//    route()->delete("/banner/delete","BannerController@deleteBanner");
//});

//route()->group(['prefix' => '/upload', 'middleware' => 'dispatch'],function(){
//    route()->post("/image","CommonController@uploadImage");
//    route()->post("/video","CommonController@uploadVideo");
//});

//首页
route()->group(['prefix' => '/index', 'middleware' => 'dispatch'],function(){
    route()->get("/class","IndexController@listClass");
    route()->get("/banner","IndexController@listBanner");
});

//文章详情页
route()->group(['prefix' => '/article', 'middleware' => 'dispatch'],function(){
    route()->get("/info","ArticleController@getArticle");
});

//课程详情页
route()->group(['prefix' => '/class', 'middleware' => 'dispatch'],function(){
    route()->get("/info","ClassController@getClass");
    route()->get("/try","ClassController@getClassTry");
    route()->get("/chapter","ClassController@getClassChapter");
    route()->post("/buyClass","ClassController@createOrder")->withAddMiddleware("login");
    route()->post("/buyClass/wxapp","Wxapp\ClassController@createOrder")->withAddMiddleware("login");
});

//个人中心首页
route()->group(['prefix' => '/me', 'middleware' => 'dispatch'],function(){
    route()->get("/info","MeController@getUser")->withAddMiddleware("login");
});

//我的课程列表
route()->group(['prefix' => '/my_class_list', 'middleware' => 'dispatch'],function(){
    route()->get("/list","MyClassListController@listUserClass")->withAddMiddleware("login");
});

//我的课程详情
route()->group(['prefix' => '/my_class', 'middleware' => 'dispatch'],function(){
    route()->get("/info","MyClassController@getClassChapter")->withAddMiddleware("login");
    route()->post("/learn_percent","MyClassController@updateLearnPercent")->withAddMiddleware("login");
});

//测试页面
route()->group(['prefix' => '/test', 'middleware' => 'dispatch'],function(){
    route()->get("/get","TestController@getTest")->withAddMiddleware("login");
    route()->get("/get_ask","TestController@getAsk")->withAddMiddleware("login");
    route()->get("/get_answer","TestController@randAnswer")->withAddMiddleware("login");
});

//公用接口
route()->group(['prefix' => '/common', 'middleware' => 'dispatch'],function(){
    route()->get("/login","CommonController@login");
     
    route()->post("/jssdk","CommonController@wechatJssdk");
});

//小程序接口
route()->group(['prefix' => '/wxapp', 'middleware' => 'wxapp_dispatch'], function(){
    route()->post("/login","CommonController@wxappLogin");
});

//后台
route()->group("/admin",function(){

    //公用接口
    route()->post("/common/login","AdminCommonController@login");
    route()->post("/common/upload_image","AdminCommonController@uploadImage");
    route()->post("/common/upload_video","AdminCommonController@uploadVideo");


    //用户管理
    route()->get("/user/list","AdminUserController@listUser");

    //课程管理
    route()->get("/class/list","AdminClassController@listClass");
    route()->get("/class/get","AdminClassController@getClass");
    route()->post("/class/add","AdminClassController@addClass");
    route()->post("/class/update","AdminClassController@updateClass");
    route()->post("/class/delete","AdminClassController@deleteClass");

    //课程介绍管理
    route()->get("/intro/list","AdminClassIntroduceController@listIntroduce");
//    route()->get("/intro/get","AdminClassIntroduceController@getBanner");
    route()->post("/intro/add","AdminClassIntroduceController@addIntroduce");
    route()->post("/intro/update","AdminClassIntroduceController@updateIntroduce");
    route()->post("/intro/delete","AdminClassIntroduceController@deleteIntroduce");

    //课程试听管理
    route()->get("/try/list","AdminClassTryController@listTry");
//    route()->get("/try/get","AdminClassTryController@getBanner");
    route()->post("/try/add","AdminClassTryController@addTry");
//    route()->post("/try/update","AdminClassTryController@updateBanner");
    route()->post("/try/delete","AdminClassTryController@deleteTry");

    //课程章节管理
    route()->get("/chapter/list","AdminClassChapterController@listChapter");
//    route()->get("/chapter/get","AdminClassChapterController@getBanner");
    route()->post("/chapter/add","AdminClassChapterController@addChapter");
    route()->post("/chapter/update","AdminClassChapterController@updateChapter")->withAddMiddleware("filter");
    route()->post("/chapter/delete","AdminClassChapterController@deleteChapter");

    //章节课时管理
    route()->get("/lesson/list","AdminClassLessonController@listLesson");
//    route()->get("/lesson/get","AdminClassLessonController@getBanner");
    route()->post("/lesson/add","AdminClassLessonController@addLesson");
//    route()->post("/lesson/update","AdminClassLessonController@updateLesson");
    route()->post("/lesson/delete","AdminClassLessonController@deleteLesson");
    route()->post("/lesson/update","AdminClassLessonController@updateLesson");

    //订单列表
    route()->post("/order/list","AdminOrderController@listOrder");

    //轮播图管理
    route()->get("/banner/list","AdminBannerController@listBanner");
    route()->get("/banner/get","AdminBannerController@getBanner");
    route()->post("/banner/add","AdminBannerController@addBanner");
    route()->post("/banner/update","AdminBannerController@updateBanner");
    route()->post("/banner/delete","AdminBannerController@deleteBanner");

    //收入统计
    route()->get("/income/static","AdminIncomeStaticController@incomeStatic");

    //测试首页
    route()->get("/test/list","AdminTestController@listTest");
    route()->post("/test/add","AdminTestController@addTest");
    route()->post("/test/delete","AdminTestController@deleteTest");
    route()->post("/test/update","AdminTestController@updateTest");

    //测试的问题
    route()->get("/test_ask/list","AdminTestController@listAsk");
    route()->post("/test_ask/add","AdminTestController@addAsk");
    route()->post("/test_ask/delete","AdminTestController@deleteAsk");
    route()->post("/test_ask/update","AdminTestController@updateAsk");
    route()->post("/test_option/delete","AdminTestController@deleteOption");

    //测试的回答
    route()->get("/test_answer/list","AdminTestController@listAnswer");
    route()->post("/test_answer/add","AdminTestController@addAnswer");
    route()->post("/test_answer/delete","AdminTestController@deleteAnswer");
    route()->post("/test_answer/update","AdminTestController@updateAnswer");

    //参加测试的用户列表
    route()->get("/user_test/list","AdminUserTestController@listUserTest");
});

//微信客服消息接口

route()->group("/wechat",function(){
    route()->get("/customer","WechatController@wxapp");
    route()->post("/customer","WechatController@wxapp");
    route()->put("/customer","WechatController@wxapp");
});

route()->group(["prefix" => "/wxapp", "middleware" => "dispatch"],function(){
    route()->post("/user/update","CommonController@updateUser");
});



