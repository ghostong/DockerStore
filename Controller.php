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

        $this->post('/api/cleanImage',function ($request){
            return Model("Api")->cleanImage($request);
        });

        $this->post('/api/cleanContainer',function ($request){
            return Model("Api")->cleanContainer($request);
        });

    }

}