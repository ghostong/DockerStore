<?php

class ApiModel extends \Lit\LitMs\LitMsModel{


    function allContainerList(){
        $outPut = [];
        $appList = Model("App")->listApp();
        foreach ($appList as $val) {
            $outPut[] = Model("App")->getAppConfig($val);
        }
        return Success($outPut);
    }

}