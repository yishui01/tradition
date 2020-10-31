<?php

function route_class()
{
    return str_replace('.', '-', \Illuminate\Support\Facades\Route::currentRouteName());
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
