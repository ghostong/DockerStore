<?php

function buildAllAppImage(){
    $appModel = Model("App");
    $appList = $appModel->listApp();
    foreach($appList as $val) {
        $dir = $appModel->getAppDir($val);
        Model("Docker")->buildImageOnStart($dir);
    }

}


buildAllAppImage();
