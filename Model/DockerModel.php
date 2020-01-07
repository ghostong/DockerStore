<?php
/**
 * Created by IntelliJ IDEA.
 * User: ghost
 * Date: 2019-11-08
 * Time: 15:18
 */

class DockerModel extends \Lit\LitMs\LitMsModel{

    function getRunningContainer(){
        $cmd = 'docker ps |grep -v "CONTAINER ID" |awk \'{print $NF}\'';
        echo $cmd,"\n";
        exec($cmd,$execRet);
        return $execRet;
    }

    function startContainer($dir){
        $cmd = "cd $dir && docker-compose up -d";
        echo $cmd,"\n";
        exec($cmd,$exeRes, $return_var);
        if ( $return_var == 0 ) {
            return true;
        }else{
            return false;
        }
    }

    function removeContainer($dir){
        $cmd = "cd $dir && docker-compose rm -sf";
        echo $cmd,"\n";
        exec($cmd,$exeRes, $return_var);
        if ( $return_var == 0 ) {
            return true;
        }else{
            return false;
        }
    }

    function restartContainer($dir){
        $cmd = "cd $dir && docker-compose restart ";
        echo $cmd,"\n";
        exec($cmd,$exeRes, $return_var);
        if ( $return_var == 0 ) {
            return true;
        }else{
            return false;
        }
    }

    function removeImage($appName){
        $cmd = "docker rmi -f ".strtolower($appName);
        echo $cmd,"\n";
        exec($cmd,$exeRes, $return_var);
        if ( $return_var == 0 ) {
            return true;
        }else{
            return false;
        }
    }

    function getDockerBaseImage($file){
        $cmd = 'cat '.$file.'  |grep -i from |awk \'{print $NF}\'';
        echo $cmd,"\n";
        exec($cmd,$execRes);
        $imageName = current($execRes);
        return $imageName;
    }

    function pullImage($imageName) {
        $cmd = 'docker pull '. $imageName;
        echo $cmd,"\n";
        passthru($cmd);
    }

    function buildImage($dir){
        $cmd = "cd $dir && docker-compose build";
        echo $cmd,"\n";
        passthru($cmd);
    }

    function cleanImage(){
        $cmd = 'docker images |grep \'<none>\' |awk \'{print $3}\' |xargs -i docker rmi {}';
        echo $cmd,"\n";
        exec($cmd,$execRes);
        return $execRes;
    }

    function cleanContainer(){
        $cmd = 'docker ps -a |grep -i \'exited\' |awk \'{print $1}\' |xargs -i docker rm {}';
        echo $cmd,"\n";
        exec($cmd,$execRes);
        return $execRes;
    }

    function getConfigFileContent( $appId, $configFile ){
        $cmd = "docker exec {$appId} cat {$configFile}";
        echo $cmd,"\n";
        exec($cmd,$execRes);
        return $execRes;
    }

    function setConfigFileContent ( $appId,$configFile,$content ) {
        $cmdDir = "/tmp/DockerStore";
        !is_dir($cmdDir) && mkdir($cmdDir);
        $fileName = $cmdDir.DIRECTORY_SEPARATOR.uniqid().".sh";
        $shellCmd = "#!/bin/sh\ncat > $configFile <<'EOF'\n{$content}\nEOF";
        file_put_contents($fileName,$shellCmd);
        $cmd = "docker exec {$appId} sh {$fileName} && echo 1";
        echo $cmd,"\n";
        exec($cmd,$execRes);
        $cmd = "docker exec {$appId} rm {$fileName}";
        echo $cmd,"\n";
        exec($cmd);
        return $execRes;
    }

    function getAppLogs ($dir) {
        $cmd = "cd $dir && docker-compose logs --no-color | tail -500 ";
        echo $cmd,"\n";
        exec($cmd,$execRes);
        return $execRes;
    }

    function createNetWork( $newWorkName = "dockerstore"){
        $cmd = "docker network create {$newWorkName} 2>&1 >/dev/null";
        echo $cmd."\n";
        exec($cmd, $execRes);
        return $execRes;
    }

    function cleanDockerStoreImages (){
        $app = Model("App");
        $appList =  $app->listApp() ;
        if ($appList) {
            foreach ($appList as $appName) {
                $appDir = $app->getAppDir($appName);
                $this->removeContainer($appDir);
                $this->removeImage($appName);
            }
            return true;
        }else{
            return false;
        }
    }

    function uninstallDockerStore () {
        $this->cleanDockerStoreImages();
        $cmd = "docker rm -f DockerStore || docker images |grep -E \"/litosrc/ds|litosrc/docker-store \" |awk '{print $3}' |xargs -i docker rmi {}";
        echo $cmd,"\n";
        exec($cmd,$exeRes, $return_var);
        if ( $return_var == 0 ) {
            return true;
        }else{
            return false;
        }
    }

    function getAllImages(){
        $cmd = "docker images |grep -v REPOSITORY |awk '{print $1}'";
        echo $cmd,"\n";
        exec($cmd,$exeRes);
        return $exeRes;
    }
}