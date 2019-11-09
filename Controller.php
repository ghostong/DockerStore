<?php
/**
 * LitMs Controller 层
 */

class Controller extends Lit\LitMs\LitMsController {

    function __construct(){
        $this->all('/',function (){
            return View("Index.html");
        });

        $this->all('/allApp',function (){
            return View("AllApp.html");
        });

        $this->all('/help',function (){
            return View("Help.html");
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

    }

}