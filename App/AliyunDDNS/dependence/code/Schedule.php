<?php
$config = (new ConfigModel())->getConfig();
var_dump($config);
Lit\Ms\LitMsSchedule::every( $config['interval'] ? : 600, function (){
    (new ScheduleModel())->UpdateDomain();
},"UpdateDomain Every ".$config["interval"]."s");