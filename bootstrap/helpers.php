<?php


function route_class()
{
    $name = str_replace('.', '-', \Illuminate\Support\Facades\Route::currentRouteName());
    if ($name == 'root') {
        return "posts-index";
    }
    return $name;
}

function setActive($routerName, $activeId = 0)
{
    $nowUrl = $activeId ? route($routerName, $activeId) : route($routerName);
    if (request()->url() == $nowUrl) {
        return "active";
    }
    return "";
}

function checkQuery($queryName, $queryValue = 0, $reverse = false)
{
    if ($reverse) {
        return request()->get($queryName) != $queryValue ? "active" : "";
    }
    return request()->get($queryName) == $queryValue ? "active" : "";
}

function make_excerpt($content, $length = 200)
{
    $excerpt = trim(preg_replace("/\r\n|\r|\n+/", " ", strip_tags($content)));
    return \Illuminate\Support\Str::limit($excerpt, $length);
}


/**
 * 兼容老版本第三方包使用函数
 * @param $array
 * @param $str
 * @return mixed
 */
function array_get($array, $str)
{
    return \Illuminate\Support\Arr::get($array, $str);
}

function str_finish($value, $cap)
{
    return \Illuminate\Support\Str::finish($value, $cap);
}
