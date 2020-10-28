<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use GuzzleHttp\Client;


class DDNSModel extends Lit\Ms\LitMsModel
{

    protected $config;

    public function __construct() {
        $this->config = (new ConfigModel())->getConfig();
        AlibabaCloud::accessKeyClient(
            $this->config['accessKeyId'],
            $this->config['accessKeySecret']
        )->regionId($this->config['regionId'])->asDefaultClient();
    }

    public function domainList ( $domain ) {
        try {
            $result = AlibabaCloud::rpc()->product('Alidns')
                ->version('2015-01-09')->action('DescribeDomainRecords')
                ->method('POST')->host('alidns.aliyuncs.com')
                ->options(['query' => ['DomainName' => $domain ]])->request();
            if ( $result->getStatusCode() == 200 ) {
                $result = $result->toArray();
                $return = [];
                foreach ( $result["DomainRecords"]["Record"] as $val ) {
                    $return[] = $val;
                }
                return $return;
            }else{
                return [];
            }
        }catch (Exception $e) {
            return [];
        }
    }

    public function updateDomain( $regionId, $recordId, $rr , $ip ){
        try {
            $result = AlibabaCloud::rpc()->product('Alidns')->version('2015-01-09')
                ->action('UpdateDomainRecord')->method('POST')->host('alidns.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => $regionId,
                        'RecordId' => $recordId,
                        'RR' => $rr,
                        'Value' => $ip,
                        "Type" => "A"
                    ],
                ])->request();
            print_r($result->toArray());
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }

    public function getIp () {
        $client = new Client(['timeout'  => 20]);
        $response = $client->get('https://api.ipify.org/');
        if( $response->getStatusCode() == 200 ) {
            $ip = trim($response->getBody()->getContents());
            if( !empty($ip) ) {
                return $ip;
            }
        }
        return "";
    }

}