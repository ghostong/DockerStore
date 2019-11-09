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
        exec($cmd,$execRet);
        return $execRet;
    }

    function startContainer($dir){
        $cmd = "cd $dir && docker-compose build && docker-compose up -d";
        go(function () use ($cmd) {
            echo $cmd."\n";
            co::exec($cmd);
        });
        return true;
    }

    function removeContainer($dir){
        $cmd = "cd $dir && docker-compose stop && docker-compose rm -f";
        go(function () use ($cmd) {
            echo $cmd."\n";
            co::exec($cmd);
        });
        return true;
    }

    function buildImageOnStart($dir){
        $cmd = "cd $dir && docker-compose build";
        passthru($cmd);
    }
}