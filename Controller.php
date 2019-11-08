<?php
/**
 * LitMs Controller 层
 */

class Controller extends Lit\LitMs\LitMsController {

    function __construct(){
        $this->all('/',function ($request,&$response){
            return View("Index.html");
        });

        $this->all('/allContainer',function ($request,&$response){
            return View("AllContainer.html");
        });

        $this->all('/help',function ($request,&$response){
            return View("Help.html");
        });

        $this->post('/api/getRuningContainer',function ($request,&$response){
            return "";
        });

    }

}