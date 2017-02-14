<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/uptoken', 'QiniuController@upToken');
Route::get('/', 'Web\IndexController@index');

Route::get('/login/qq', 'Web\PassportController@qqLogin');
Route::get('/doLogin/qq', 'Web\PassportController@qqDoLogin');
Route::get('/logout', 'Web\PassportController@logout');

Route::get('/forum', 'Web\ForumPostController@index');
Route::get('/forum/category/{id}', 'Web\ForumPostController@category')->where('id', '[0-9]+');
Route::get('/forum/post/{id}', 'Web\ForumPostController@show')->where('id', '[0-9]+');

Route::get('/article', 'Web\ArticleController@index');
Route::get('/article/category/{id}', 'Web\ArticleController@category')->where('id', '[0-9]+');
Route::get('/article/{id}', 'Web\ArticleController@show')->where('id', '[0-9]+');
Route::get('/user/{id}', 'Web\UserController@show')->where('id', '[0-9]+');

Route::group(['middleware' => ['verifyWebPassport','verifyWebUserInfo']], function () {
	Route::get('/forum/post/pub', 'Web\ForumPostController@create');
	Route::post('/forum/post', 'Web\ForumPostController@store');
	Route::post('/forum/reply', 'Web\ForumReplyController@store');
	Route::post('/forum/praise', 'Web\ForumPostPraiseController@store');
	Route::delete('/forum/praise', 'Web\ForumPostPraiseController@destory');
	Route::get('/user/reward', 'Web\UserController@reward');
	Route::post('/user/reward', 'Web\UserController@updateReward');
	Route::get('/user/info', 'Web\UserController@info');
	Route::post('/user/info', 'Web\UserController@updateInfo');
});

Route::get('/admin/index', 'Admin\IndexController@index');
Route::post('/admin/login','Admin\IndexController@login');
Route::group(['middleware' => ['verifyAdminUser']], function () {

	Route::resource('/admin/administrators/user', 'Admin\AdminUserController');
	Route::resource('/admin/forum/category', 'Admin\ForumCategoryController');

	Route::resource('/admin/article/category', 'Admin\ArticleCategoryController');
	Route::resource('/admin/article/article', 'Admin\ArticleController');
	
	Route::get('/admin/ad/ad/getById', 'Admin\AdController@getById')->where('id', '[0-9]+');
	Route::resource('/admin/ad/ad', 'Admin\AdController');
});