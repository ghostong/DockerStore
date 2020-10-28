<?php
$config = (new ConfigModel())->getConfig();
Lit\Ms\LitMsSchedule::every( $config['interval'] ? : 600, function (){
    (new ScheduleModel())->UpdateDomain();
},"UpdateDomain Every ". ($config["interval"] ? : 600) ." s");