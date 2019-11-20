<?php

$argv1 = @$_SERVER['argv'][1];

function buildAppAppImage(){
    $appModel = Model("App");
    $appList = $appModel->listApp();
    foreach($appList as $val) {
        $dir = $appModel->getAppDir($val);
        Model("Docker")->buildImage($dir);
    }
}

if ($argv1 == "install") {
    buildAppAppImage();
    exit;
}

if ($argv1 == "update") {
    $dockerDir = __DIR__.DIRECTORY_SEPARATOR."Docker".DIRECTORY_SEPARATOR;
    $cmd = "cd ".$dockerDir."BaseImage && docker-compose pull";
    passthru($cmd);
    $cmd = "cd ".$dockerDir."BaseImagePhpNginx && docker-compose pull";
    passthru($cmd);
    $cmd = "cd ".$dockerDir."DockerStore && docker-compose pull";
    passthru($cmd);
    buildAppAppImage();
    exit;
}

