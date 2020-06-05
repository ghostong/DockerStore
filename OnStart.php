<?php

//启动服务
$argv1 = @$_SERVER['argv'][1];
$argv2 = @$_SERVER['argv'][2];

function dockerStoreInstall(){
    $appModel = new AppModel();
    $appList = $appModel->listApp();
    foreach($appList as $val) {
        $dir = $appModel->getAppDir($val);
        (new DockerModel())->buildImage($dir);
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
    $appModel = new AppModel();
    $config = $appModel->getAppConfig($appName);
    if (!empty($config)) {
        echo "Start build App ",$appName,PHP_EOL;
        $dir = $appModel->getAppDir($appName);
        (new DockerModel())->buildImage($dir);
    }else{
        echo "Can not find App ",$appName,PHP_EOL;
    }
}

function dockerStartOne ( $appName ) {
    $appModel = new AppModel();
    $config = $appModel->getAppConfig($appName);
    if (!empty($config)) {
        echo "Start up App ",$appName,PHP_EOL;
        $dir = $appModel->getAppDir($appName);
        (new DockerModel())->startContainer($dir);
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
    $appModel = new AppModel();
    $dir = $appModel->getAppDir("WebSSH");
    (new DockerModel())->buildImage($dir);
    exit;
} elseif ($argv1 == "build"){
    dockerBuildOne($argv2);
    exit;
} elseif ($argv1 == "up"){
    dockerStartOne($argv2);
    exit;
} elseif ($argv1 == "ps"){
    $running = (new AppModel())->getRunningApp($argv2);
    foreach ($running as $v) {
        echo "- ",$v,PHP_EOL;
    }
    exit;
} elseif ($argv1 == "rm"){
    if ( (new AppModel())->removeApp($argv2) ) {
        echo "Success",PHP_EOL;
    }else{
        echo "Not Found ", $argv2, PHP_EOL;
    }
    exit;
} elseif ($argv1 == "rmi"){
    if ( (new DockerModel())->removeImage($argv2) ) {
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
(new DockerModel())->createNetWork();

//ssl证书
function copySslCertificate(){
    $dir = "/Volumes/DockerStore/DockerStore/SSL/";
    !is_dir($dir) && mkdir($dir ,755,true);
    copy("./SSL/dockerstore.ssh2.cc.key","/Volumes/DockerStore/DockerStore/SSL/dockerstore.ssh2.cc.key");
    copy("./SSL/dockerstore.ssh2.cc.pem","/Volumes/DockerStore/DockerStore/SSL/dockerstore.ssh2.cc.pem");
    copy("./SSL/iis-dockerstore.ssh2.cc.pfx","/Volumes/DockerStore/DockerStore/SSL/iis-dockerstore.ssh2.cc.pfx");
    copy("./SSL/iis-pfx-password.txt","/Volumes/DockerStore/DockerStore/SSL/iis-pfx-password.txt");
}

copySslCertificate();

