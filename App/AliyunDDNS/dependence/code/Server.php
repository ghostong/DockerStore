<?php
//autoload
require(__DIR__ . '/vendor/autoload.php');
$server = new \Lit\Ms\LitMsServer();
$server
    ->setHttpHost("0.0.0.0")    //设置监听host ip
    ->setHttpPort(9000)    //设置 监听端口
    ->setWorkerNum(5)    //设置 进程数量
    ->setWorkDir(__DIR__)    //设置项目目录
    ->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR)    //设置静态目录
    ->setDaemonize(true)    //设置是否守护进程
    ->setOpenBaseDir(__DIR__)    //设置读取安全目录
    ->setOpenBaseDir("/tmp")    //设置读取安全目录
    ->setSlowTimeOut(1)    //设置慢日志时间
    ->setOnStart(__DIR__.DIRECTORY_SEPARATOR."OnStart.php")     //设置启动时先执行的一个文件
    ->run();