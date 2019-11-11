<?php

//autoload
require(__DIR__.'/vendor/autoload.php');

$server = new \Lit\LitMs\LitMsServer();

$server
    ->setHttpHost("0.0.0.0")    //设置监听host ip
    ->setHttpPort(9000)    //设置 监听端口
    ->setWorkerNum(10)    //设置 进程数量
    ->setWorkDir(__DIR__)    //设置项目目录
    ->setDaemonize(false)    //设置是否守护进程
    ->setOpenBaseDir(__DIR__)    //设置读取安全目录
    ->setDocumentRoot(__DIR__.DIRECTORY_SEPARATOR."Static")    //设置静态目录
    ->setAuthenticate(['ghost'=>'b.b.xixihaha.']) ;   //开启简单身份认证,设置用户名密码

if (isset($argv[1]) && $argv[1] == "install") {
    $server->setOnStart(__DIR__.DIRECTORY_SEPARATOR."OnStart.php");    //设置启动时先执行的一个文件
}

$server->run();