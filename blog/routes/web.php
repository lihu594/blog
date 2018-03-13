<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//前台路由--------------------------------------------------------------------------------------
Route::group(['namespace'=>'Home','middleware'=>'web'], function(){
    Route::get('/', 'IndexController@index');
    Route::get('/cate/{cate_id}', 'IndexController@cate');
    Route::get('/a/{art_id}', 'IndexController@article');



});



//后台路由-------------------------------------------------------------------------------------
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'web'], function(){
    Route::any('login', 'LoginController@login');
    Route::any('code', 'LoginController@code');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['web','admin.login']], function(){
    Route::get('/', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    //文件上传
    Route::any('upload', 'CommonController@upload');

    //文章分类路由
    Route::resource('category','CategoryController');
    Route::post('cate/changeorder', 'CategoryController@changeOrder'); //更新排序

    //文章路由
    Route::resource('article','ArticleController');

    //友情链接路由
    Route::resource('links','LinksController');
    Route::post('links/changeorder', 'LinksController@changeOrder'); //更新排序

    //导航路由
    Route::resource('navs','NavsController');
    Route::post('navs/changeorder', 'NavsController@changeOrder'); //更新排序

    //网站配置参数路由

    Route::get('config/putfile','ConfigController@putFile'); //配置项写入文件
    Route::post('config/changecontent','ConfigController@changeContent'); //更新内容
    Route::post('config/changeorder','ConfigController@changeOrder'); //更新排序
    Route::resource('config','ConfigController');
});
