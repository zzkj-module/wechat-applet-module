<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

// 微信小程序
Route::any('wechat_applet/setting', 'WechatAppletController@setting');
Route::any('wechat_applet/template', 'WechatAppletController@template');
