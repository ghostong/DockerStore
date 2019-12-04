<?php


class AppModel extends \Lit\LitMs\LitMsModel{


    function getAppRoot () {
        return LITMS_WORK_DIR."App".DIRECTORY_SEPARATOR;
    }

    function getAppDir( $appId){
        return $this->getAppRoot().$appId.DIRECTORY_SEPARATOR;
    }

    //获取APP列表
    function listApp () {
        $appDir = $this->getAppRoot();
        if (!$appDir){
            return [];
        }
        $dirArray = [];
        $fileIterator = new FilesystemIterator( $appDir );
        foreach($fileIterator as $val) {
            if($val->isDir()){
                $dirArray[] = $val->getFileName();
            }
        }
        return $dirArray;
    }

    //获取单个APP配置
    function getAppConfig( $appId ){
        $config = [];
        $configFile =  $this->getAppDir($appId)."config.json";
        if(is_file($configFile)) {
            $fileStr = file_get_contents($configFile);
            if ($fileStr) {
                $config = json_decode(trim($fileStr),true);
                $config["appId"] = $appId;
            }
        }
        return $config;
    }

    //获取正在运行的APP
    function getRunningApp(){
        $runningApp = [];
        $appList = $this->listApp();
        if ($appList){
            $runningContainer = Model("Docker")->getRunningContainer();
            if ($runningContainer) {
                $appTmpList = array_map("strtolower",$appList);
                $runningContainer = array_map("strtolower",$runningContainer);
                $appTmpRunning = array_intersect($runningContainer,$appTmpList);
                foreach($appList as $appName) {
                    if ( in_array(strtolower($appName),$appTmpRunning) ) {
                        $runningApp[] = $appName;
                    }
                }
            }
        }
        return $runningApp;
    }
    
    //启动APP
    function startApp ( $appId ) {
        if ($this->getAppConfig($appId)) {
            $appDir = $this->getAppDir($appId);
            if(Model("Docker")->startContainer($appDir)){
                return true;
            }
        }
        return false;
    }

    //删除App
    function removeApp ( $appId ) {
        if ($this->getAppConfig($appId)) {
            $appDir = $this->getAppDir($appId);
            if(Model("Docker")->removeContainer($appDir)){
                return true;
            }
        }
        return false;
    }

    //重启App
    function restartApp ( $appId ) {
        if ($this->getAppConfig($appId)) {
            $appDir = $this->getAppDir($appId);
            if(Model("Docker")->restartContainer($appDir)){
                return true;
            }
        }
        return false;
    }

    //获取App配置文件
    function getAppFileContent( $appId,$configFile ){
        $ret = Model("Docker")->getConfigFileContent( $appId, $configFile );
        return implode("\n",$ret);
    }

    //保存配置文件
    function saveConfigContent ($appId,$configFile,$content) {
        $ret = Model("Docker")->setConfigFileContent( $appId,$configFile,$content );
        if ($ret) {
            return true;
        }else{
            return false;
        }
    }

    //获取容器log
    function getAppLogs ($appId) {
        $appDir = $this->getAppDir($appId);
        $ret = Model("Docker")->getAppLogs( $appDir );
        return implode("\n",$ret);
    }
}