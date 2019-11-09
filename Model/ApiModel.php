<?php

class ApiModel extends \Lit\LitMs\LitMsModel{

    //所有app列表
    function allAppList(){
        $outPut = [];
        $appList = Model("App")->listApp();
        $runingApp = Model("App")->getRunningApp();
        foreach ($appList as $val) {
            $config = Model("App")->getAppConfig($val);
            if(in_array($config["appId"],$runingApp)){
                $config["isRunning"] = 1;
            }else{
                $config["isRunning"] = 0;
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
        $runingApp = Model("App")->getRunningApp();
        foreach ($runingApp as $appName) {
            $config = Model("App")->getAppConfig($appName);
            if($config['httpPort']){
                $config['webUi'] = "http://".$host.":".$config['httpPort'];
            }else{
                $config['webUi'] = "未开放";
            }
            if($config['appPorts']){
                $config['ports'] = implode(" ",$config['appPorts']);
            }else{
                $config['ports'] = "未开放";
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
}