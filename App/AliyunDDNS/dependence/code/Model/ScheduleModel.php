<?php


class ScheduleModel extends \Lit\Ms\LitMsModel
{

    private $path = "/tmp/last_ip.file";
    public function updateDomain(){
        $config = (new ConfigModel())->getConfig();
        $dns = new DDNSModel();
        $ip = $dns->getIp();
        if ( $this->isUpdate($ip) ) {
            foreach ($config["rr"] as $val ) {
                $dns->updateDomain( $config["regionId"],$val["recordId"], $val["rr"],$ip);
            }
            $this->saveLastIp($ip);
        }
    }

    protected function getLastIp () {
        if (is_file($this->path)){
            return trim ( file_get_contents($this->path) );
        }else{
            return "";
        }
    }

    protected function saveLastIp ( $ip ) {
        file_put_contents($this->path,$ip );
    }

    protected function isUpdate( $ip ){
        if ( !empty($ip) && $ip == $this->getLastIp() ) {
            echo $ip. " 上次已经更新过了, 跳过 \n";
            return false;
        }else{
            return true;
        }
    }

}