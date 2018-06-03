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

route()->group(['prefix' => '/upload', 'middleware' => 'dispatch'],function(){
    route()->post("/image","CommonController@uploadImage");
    route()->post("/video","CommonController@uploadVideo");
});
