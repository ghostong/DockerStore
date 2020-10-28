<?php
/**
 * LitMs 路由
 */

class Route extends Lit\Ms\LitMsRoute {

    function __construct(){

        $this->all('/',function ( $request, $response ) {
            return (new DDNSController())->domainList( $request, $response );
        });

    }

}