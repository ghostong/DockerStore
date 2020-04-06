<?php

class ApiModel extends \Lit\Ms\LitMsModel{

    //所有app列表
    function allAppList(){
        $outPut = [];
        $appList = Model("App")->listApp();
        $runningApp = Model("App")->getRunningApp();
        $buildApp = Model("Docker")->getAllImages();
        foreach ($appList as $val) {
            $config = Model("App")->getAppConfig($val);
            if(in_array($config["appId"],$runningApp)){
                $config["isRunning"] = 1;
            }else{
                $config["isRunning"] = 0;
            }
            if (in_array(strtolower($config["appId"]),$buildApp)){
                $config["isBuild"] = 1;
            }else{
                $config["isBuild"] = 0;
            }
            $outPut[] = $config;
        }
        return Success($outPut);
    }

    //启动app
    function startApp ($request) {
        $appId = $request->post['appId'];
        if ($appId && Model("App")->startApp ($appId)) {
            return Success();
        }else{
            return Error();
        }
    }

    //获取正在运行app
    function getRunningApp ($request) {
        $host = $request->header['host'];
        $host = current(explode(":",$host));
        $outPut = [];
        $runningApp = Model("App")->getRunningApp();
        if (in_array("WebSSH",$runningApp)) {
            $webSSH = true;
        }else{
            $webSSH = false;
        }
        foreach ($runningApp as $appName) {
            $config = Model("App")->getAppConfig($appName);
            if($config['httpPort']){
                if(isset($config['httpsOnly']) && $config['httpsOnly']) {
                    $config['webUi'] = "https://".$host.":".$config['httpPort'];
                }else{
                    $config['webUi'] = "http://".$host.":".$config['httpPort'];
                }
            }else{
                $config['webUi'] = "";
            }
            if($config['appPorts']){
                $config['ports'] = implode(" ",$config['appPorts']);
            }else{
                $config['ports'] = "未开放";
            }
            if(!isset($config['auth']) || !$config['auth']) {
                $config['auth'] = "无";
            }
            if(!isset($config["appConfig"])){
                $config["appConfig"] = "";
            }
            if ( $webSSH ) {
                $config["webSSH"] = 1;
            }else{
                $config["webSSH"] = 0;
            }
            $outPut[] = $config;
        }
        return Success($outPut);
    }

    //删除app
    function removeApp ($request) {
        $appId = $request->post['appId'];
        if ($appId && Model("App")->removeApp ($appId)) {
            return Success();
        }else{
            return Error();
        }
    }

    //重启app
    function restartApp ($request) {
        $appId = $request->post['appId'];
        if ($appId && Model("App")->restartApp ($appId)) {
            return Success();
        }else{
            return Error();
        }
    }

    //清理无用镜像
    function cleanImage(){
        if ( Model("Docker")->cleanImage() ) {
            return Success();
        }else{
            return Error();
        }
    }

    //清理退出容器
    function cleanContainer(){
        if ( Model("Docker")->cleanContainer() ) {
            return Success();
        }else{
            return Error();
        }
    }

    //清理dockerStore产生的镜像
    function cleanDockerStoreImages(){
        if ( Model("Docker")->cleanDockerStoreImages() ) {
            return Success();
        }else{
            return Error();
        }
    }

    //获取配置文件列表
    function getConfigList ($request) {
        $config = Model("App")->getAppConfig($request->get['appId']);
        if($config['appConfig']){
            return Success($config['appConfig']);
        }else{
            return Error();
        }
    }

    //获取配置文件
    function getConfigContent ($request) {
        $appId = $request->get['appId'];
        $config = Model("App")->getAppConfig($appId);
        if($config['appConfig']){
            $configFile = $config['appConfig'][$request->get['fileId']];
            $configFileContent = Model("App")->getAppFileContent($appId,$configFile["file"]);
            return Success(["content"=>$configFileContent]);
        }else{
            return Error();
        }
    }

    //保存配置文件
    function saveConfigContent ($request) {
        $appId = $request->post['appId'];
        $fileId = $request->post['fileId'];
        $content = $request->post['content'];
        $config = Model("App")->getAppConfig($appId);
        if($config['appConfig']){
            $configFile = $config['appConfig'][$fileId];
            if(Model("App")->saveConfigContent($appId,$configFile["file"],$content)){
                return Success();
            }else{
                return Error();
            }
        }else{
            return Error();
        }
    }

    //获取容器log
    function getAppLogs ($request) {
        $appId = $request->get['appId'];
        $log = Model("App")->getAppLogs($appId);
        if($log){
            return Success(["content"=>$log]);
        }else{
            return Error();
        }
    }

    //ssh链接
    function  sshConnect ( $request, $response ) {

        $appModel = Model("App");
        if ( ! in_array("WebSSH",$appModel->getRunningApp()) ){
            return Error(0, "必须先启动 WebSSH 服务才能使用此功能");
        }

        $action = $request->get["action"];
        $appId = $request->get['appId'];
        $host = $request->header['host'];
        $host = current(explode(":",$host));

        //先生成一个随机密码
        $pwd = uniqid().rand(10000,99999);
        $newCmd = "docker exec -it WebSSH bash -c 'echo dockerstore:{$pwd} | chpasswd'";
        exec ($newCmd);

        //登录地址
        $passwd = base64_encode($pwd);
        if ($action == "ssh") {
            $command = "sudo docker exec -it {$appId} sh -c 'clear;sh' ";
        } elseif ($action == "build") {
            $appModel = Model("App");
            $dir = $appModel->getAppDir($appId);
            $buildCmd = Model("Docker")->buildImage($dir,true);
            $buildCmd = str_replace("&&",";",$buildCmd);
            $command = "sudo docker exec -it DockerStore bash -c '{$buildCmd}'";
        } else{
            $command = "ls";
        }
        $url = "https://".$host.":9112?hostname=127.0.0.1&username=dockerstore&password={$passwd}&command={$command}";

        //密码设为无效
        go(function () {
            $pwd = uniqid().rand(10000,99999);
            $newCmd = "sleep 2 && docker exec -it WebSSH bash -c 'echo dockerstore:{$pwd} | chpasswd'";
            co::exec($newCmd);
        });
        return'<meta http-equiv="refresh" content="0; url='.$url.'">';
    }

    //清理dockerStore产生的镜像
    function uninstallDockerStore(){
        if ( Model("Docker")->uninstallDockerStore() ) {
            return Success();
        }else{
            return Error();
        }
    }
}