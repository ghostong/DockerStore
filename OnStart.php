<?php

function buildAppAppImage(){
    $appModel = Model("App");
    $appList = $appModel->listApp();
    foreach($appList as $val) {
        $dir = $appModel->getAppDir($val);
        Model("Docker")->buildImage($dir);
    }
}

buildAppAppImage();
exit();