<?php

$argv1 = @$_SERVER['argv'][1];

function dockerStoreInstall(){
    $appModel = Model("App");
    $appList = $appModel->listApp();
    foreach($appList as $val) {
        $dir = $appModel->getAppDir($val);
        Model("Docker")->buildImage($dir);
    }
}

function dockerStoreUpdate(){
    $cmd = "docker pull registry.cn-hangzhou.aliyuncs.com/litosrc/ubuntu-1804:latest";
    echo $cmd,"\n";
    passthru($cmd);
    $cmd = "docker pull registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest";
    echo $cmd,"\n";
    passthru($cmd);
    $cmd = "docker pull registry.cn-hangzhou.aliyuncs.com/litosrc/ds-php-nginx:latest";
    echo $cmd,"\n";
    passthru($cmd);
}

if ($argv1 == "install") {
    dockerStoreInstall();
    exit;
}elseif ($argv1 == "update") {
    dockerStoreUpdate();
    exit;
} elseif ($argv1 == "upgrade") {
    dockerStoreUpdate();
    dockerStoreInstall();
    exit;
} elseif ($argv1 == "fastinstall") {
    $appModel = Model("App");
    $dir = $appModel->getAppDir("WebSSH");
    Model("Docker")->buildImage($dir);
    exit;
}

Model("Docker")->createNetWork();

