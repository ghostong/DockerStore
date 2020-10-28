<?php


class ConfigModel extends \Lit\Ms\LitMsModel
{

    public function getConfig () {
        $file = file_get_contents(LITMS_WORK_DIR."/Config/config.json");
        return json_decode($file,true);
    }
}