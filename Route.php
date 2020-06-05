<?php
/**
 * LitMs Controller 层
 */

class Route extends Lit\Ms\LitMsRoute {

    function __construct(){
        $this->get('/',function (){
            return (new \Lit\Ms\LitMsResponse())->html("Index.html");
        });

        $this->get('/allApp',function (){
            return (new \Lit\Ms\LitMsResponse())->html("AllApp.html");
        });

        $this->get('/help',function (){
            return (new \Lit\Ms\LitMsResponse())->html("Help.html");
        });

        $this->get('/tool',function (){
            return (new \Lit\Ms\LitMsResponse())->html("Tool.html");
        });

        $this->get('/logs',function (){
            return (new \Lit\Ms\LitMsResponse())->html("logs.html");
        });

        $this->get('/configEdit',function(){
            return (new \Lit\Ms\LitMsResponse())->html("Edit.html");
        });

        $this->get("/sshConnect",function ($request,$response){
            return (new ApiController())->sshConnect($request,$response);
        });

        $this->post('/api/getRuningApp',function ($request){
            return (new ApiController())->getRunningApp($request);
        });

        $this->post('/api/getAllApp',function (){
            return (new ApiController())->allAppList();
        });

        $this->post('/api/startApp',function ($request){
            return (new ApiController())->startApp($request);
        });

        $this->post('/api/removeApp',function ($request){
            return (new ApiController())->removeApp($request);
        });

        $this->post('/api/restartApp',function ($request){
            return (new ApiController())->restartApp($request);
        });

        $this->post('/api/delApp',function ($request){
            return (new ApiController())->removeImage($request);
        });

        $this->post('/api/cleanImage',function ($request){
            return (new ApiController())->cleanImage($request);
        });

        $this->post('/api/cleanContainer',function ($request){
            return (new ApiController())->cleanContainer($request);
        });

        $this->get('/api/getConfigList',function ($request){
            return (new ApiController())->getConfigList($request);
        });

        $this->get('/api/getConfigContent',function ($request){
            return (new ApiController())->getConfigContent($request);
        });

        $this->post('/api/saveConfigContent',function ($request){
            return (new ApiController())->saveConfigContent($request);
        });

        $this->get("/api/getAppLogs",function ($request){
            return (new ApiController())->getAppLogs($request);
        });

        $this->post("/api/cleanDockerStoreImages",function ($request){
            return (new ApiController())->cleanDockerStoreImages($request);
        });

        $this->post("/api/uninstallDockerStore",function ($request){
            return (new ApiController())->uninstallDockerStore($request);
        });
    }

}