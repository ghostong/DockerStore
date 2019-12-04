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
        go(function () use ($cmd) {
            co::exec($cmd);
        });
        return true;
    }

    function removeContainer($dir){
        $cmd = "cd $dir && docker-compose stop && docker-compose rm -f";
        echo $cmd,"\n";
        go(function () use ($cmd) {
            co::exec($cmd);
        });
        return true;
    }

    function restartContainer($dir){
        $cmd = "cd $dir && docker-compose restart ";
        echo $cmd,"\n";
        go(function () use ($cmd) {
            co::exec($cmd);
        });
        return true;
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
        $shellCmd = "#!/bin/sh\ncat > $configFile <<EOF\n{$content}\nEOF";
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
}