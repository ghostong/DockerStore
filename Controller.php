<?php
/**
 * LitMs Controller 层
 */

class Controller extends Lit\LitMs\LitMsController {

    function __construct(){
        $this->get('/',function (){
            return View("Index.html");
        });

        $this->get('/allApp',function (){
            return View("AllApp.html");
        });

        $this->get('/help',function (){
            return View("Help.html");
        });

        $this->get('/tool',function (){
            return View("Tool.html");
        });

        $this->get('/logs',function (){
            return View("logs.html");
        });

        $this->get('/configEdit',function(){
            return View("Edit.html");
        });

        $this->get("/sshConnect",function ($request,$response){
            return Model("Api")->sshConnect($request,$response);
        });

        $this->post('/api/getRuningApp',function ($request){
            return Model("Api")->getRunningApp($request);
        });

        $this->post('/api/getAllApp',function (){
            return Model("Api")->allAppList();
        });

        $this->post('/api/startApp',function ($request){
            return Model("Api")->startApp($request);
        });

        $this->post('/api/removeApp',function ($request){
            return Model("Api")->removeApp($request);
        });
        $this->post('/api/restartApp',function ($request){
            return Model("Api")->restartApp($request);
        });

        $this->post('/api/cleanImage',function ($request){
            return Model("Api")->cleanImage($request);
        });

        $this->post('/api/cleanContainer',function ($request){
            return Model("Api")->cleanContainer($request);
        });

        $this->get('/api/getConfigList',function ($request){
            return Model("Api")->getConfigList($request);
        });

        $this->get('/api/getConfigContent',function ($request){
            return Model("Api")->getConfigContent($request);
        });

        $this->post('/api/saveConfigContent',function ($request){
            return Model("Api")->saveConfigContent($request);
        });

        $this->get("/api/getAppLogs",function ($request){
            return Model("Api")->getAppLogs($request);
        });

        $this->post("/api/cleanDockerStoreImages",function ($request){
            return Model("Api")->cleanDockerStoreImages($request);
        });

        $this->post("/api/uninstallDockerStore",function ($request){
            return Model("Api")->uninstallDockerStore($request);
        });
    }

}