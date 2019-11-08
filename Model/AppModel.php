<?php


class AppModel extends \Lit\LitMs\LitMsModel{


    function getAppDir () {
        return LITMS_WORK_DIR.DIRECTORY_SEPARATOR."Docker".DIRECTORY_SEPARATOR;
    }

    function listApp () {
        $appDir = $this->getAppDir();
        if (!$appDir){
            return [];
        }
        $dirArray = [];
        $fileIterator = new FilesystemIterator( $appDir );
        foreach($fileIterator as $val) {
            if($val->isDir()){
                $dirArray[]=$val->getFilename();
            }
        }
        return $dirArray;
    }

    function getAppConfig( $appName ){
        $appDir = $this->getAppDir();
        $configFile = $appDir.$appName.DIRECTORY_SEPARATOR."config.json";
        if(is_file($configFile)) {
            $fileStr = file_get_contents($configFile);
            if ($fileStr) {
                $config = json_decode(trim($fileStr),true);
            }else{
                $config = [];
            }
        }
        return $config;
    }
}