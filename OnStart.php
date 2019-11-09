<?php

function pullAllAppImage(){
    $appModel = Model("App");
    $appList = $appModel->listApp();
    foreach($appList as $val) {
        $dir = $appModel->getAppDir($val)."dockerfile";
        $imageName = Model("Docker")->getDockerBaseImage($dir);
        if($imageName){
            Model("Docker")->pullImage($imageName);
        }
    }
}

pullAllAppImage();