<?php

namespace App\Http\Controllers;

class DeployController extends Controller
{
    public function index()
    {
        $target = env('DEPLOY_WEB_ROOT', ''); // 服务器上 web 目录
        $token = env('DEPLOY_TOKEN', '');
        $wwwUser = env('DEPLOY_USER', '');
        $wwwGroup = env('DEPLOY_GROUP', '');

        $json = json_decode(file_get_contents('php://input'), true);
        if (empty($json['token']) || $json['token'] !== $token) {
            exit('error request');
        }
        $cmds = array(
            "cd $target ",
            "git reset --hard origin/master && git clean -f ",
            "git pull",
            "chown -R {$wwwUser}:{$wwwGroup} $target/",
        );
        foreach ($cmds as $cmd) {
            shell_exec($cmd);
        }
    }
}
