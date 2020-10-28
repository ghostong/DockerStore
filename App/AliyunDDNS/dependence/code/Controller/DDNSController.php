<?php


class DDNSController extends \Lit\Ms\LitMsController
{

    public function domainList( $request, $response  ) {
        $string = "<html><head><meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" /></head><body>";

        $response = new \Lit\Ms\LitMsResponse();
        $config = (new ConfigModel())->getConfig();
        if ( empty($config["accessKeyId"]) || empty($config["accessKeySecret"]) || $config["domain"] == "a" ) {
            $string .= "请先修改配置文件";
        }else{
            $rrs = array_map(function ( $rr ){ return $rr["rr"]; },$config["rr"]);
            $string .= "<table border=\"1\"><tr><td>RecordId</td><td>记录</td><td>域名</td><td>类型</td><td>值</td></td></tr>";
            if ( isset( $config["domain"] ) ) {
                $list = (new DDNSModel())->domainList($config["domain"]);
                foreach ($list as $val ) {
                    if( in_array ( $val["RR"], $rrs ) ) {
                        $string .= "<tr><td>{$val["RecordId"]}</td><td>{$val["RR"]}</td><td>{$val["DomainName"]}</td><td>{$val["Type"]}</td><td>{$val["Value"]}</td></td></tr>";
                    }
                }
            }
            $string .="</table></body>";
        }

        $response->string($string);
        return $response;
    }

}