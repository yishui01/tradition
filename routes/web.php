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
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::namespace("\App\Http\Controllers")->group(function ($route) {
    $route->get('/search', "PostController@search");
    $route->get('/test', "PostController@test");
    $route->get('/', 'PagesController@root')->name('root');
});

// vendor/laravel/ui/src/AuthRouteMethods.php
Auth::routes(["verify" => true]); //不加verify不会注册 email/verify等路由
