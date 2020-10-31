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

// 已经在 RouteServiceProvider 中注册默认namespace为 \App\Http\Controllers
Route::get('/search', "PostController@search");
Route::get('/test', "PostController@test");
Route::get('/', 'PagesController@root')->name('root');

// vendor/laravel/ui/src/AuthRouteMethods.php
Auth::routes(["verify" => true]); //不加verify不会注册 email/verify等路由

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

Route::resource('posts', 'PostsController',
    ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
