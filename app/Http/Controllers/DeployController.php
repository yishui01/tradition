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

        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
        if (!$signature) {
            exit('no HTTP_X_HUB_SIGNATURE');
        }
        $hash = "sha1=" . hash_hmac('sha1', file_get_contents("php://input"), $token);
        if (strcmp($signature, $hash) !== 0) {
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
