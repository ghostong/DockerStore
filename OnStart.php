<?php

//启动服务
$argv1 = @$_SERVER['argv'][1];
$argv2 = @$_SERVER['argv'][2];

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
    echo $cmd,PHP_EOL;
    passthru($cmd);
    $cmd = "docker pull registry.cn-hangzhou.aliyuncs.com/litosrc/nginx-php7fpm:latest";
    echo $cmd,PHP_EOL;
    passthru($cmd);
    $cmd = "docker pull registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest";
    echo $cmd,PHP_EOL;
    passthru($cmd);
}

function dockerBuildOne( $appName ){
    $appModel = Model("App");
    $config = $appModel->getAppConfig($appName);
    if (!empty($config)) {
        echo "Start build App ",$appName,PHP_EOL;
        $dir = $appModel->getAppDir($appName);
        Model("Docker")->buildImage($dir);
    }else{
        echo "Can not find App ",$appName,PHP_EOL;
    }
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
} elseif ($argv1 == "build"){
    dockerBuildOne($argv2);
    exit;
} elseif ($argv1 == "ps"){
    $running = Model("App")->getRunningApp($argv2);
    foreach ($running as $v) {
        echo "- ",$v,PHP_EOL;
    }
    exit;
} elseif ($argv1 == "rm"){
    if ( Model("App")->removeApp($argv2) ) {
        echo "Success",PHP_EOL;
    }else{
        echo "Not Found ", $argv2, PHP_EOL;
    }
    exit;
} elseif ($argv1 == "rmi"){
    if ( Model("Docker")->removeImage($argv2) ) {
        echo "Success",PHP_EOL;
    }else{
        echo "Not Found ", $argv2, PHP_EOL;
    }
    exit;
} elseif ($argv1) {
    echo "none",PHP_EOL;
    exit;
}

//创建共享网卡
Model("Docker")->createNetWork();



//ssl证书
function copySslCertificate(){
    $dir = "/Volumes/DockerStore/DockerStore/SSL/";
    !is_dir($dir) && mkdir($dir ,755,true);
    copy("./SSL/dockerstore.ssh2.cc.key","/Volumes/DockerStore/DockerStore/SSL/dockerstore.ssh2.cc.key");
    copy("./SSL/dockerstore.ssh2.cc.pem","/Volumes/DockerStore/DockerStore/SSL/dockerstore.ssh2.cc.pem");
}

copySslCertificate();

