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
    $dockerDir = __DIR__.DIRECTORY_SEPARATOR."Docker".DIRECTORY_SEPARATOR;
    $cmd = "cd ".$dockerDir."BaseImage && docker-compose pull";
    passthru($cmd);
    $cmd = "cd ".$dockerDir."BaseImagePhpNginx && docker-compose pull";
    passthru($cmd);
    $cmd = "cd ".$dockerDir."DockerStore && docker-compose pull";
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
}

Model("Docker")->createNetWork();

