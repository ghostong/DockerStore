<?php

class ApiController extends \Lit\Ms\LitMsController {
    private $appModel;
    private $dockerModel;
    function __construct() {
        $this->appModel = new AppModel();
        $this->dockerModel = new DockerModel();
    }

    //所有app列表
    function allAppList() {
        $outPut = [];
       
        $appList = $this->appModel->listApp();
        $runningApp = $this->appModel->getRunningApp();
        $buildApp = $this->dockerModel->getAllImages();
        foreach ($appList as $val) {
            $config = $this->appModel->getAppConfig($val);
            if (in_array($config["appId"], $runningApp)) {
                $config["isRunning"] = 1;
            } else {
                $config["isRunning"] = 0;
            }
            if (in_array(strtolower($config["appId"]), $buildApp)) {
                $config["isBuild"] = 1;
            } else {
                $config["isBuild"] = 0;
            }
            $outPut[] = $config;
        }
        return (new \Lit\Ms\LitMsResponse())->success($outPut);
    }

    //启动app
    function startApp($request) {
        $appId = $request->post['appId'];
        if ($appId && $this->appModel->startApp($appId)) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //删除镜像
    function removeImage($request) {
        $appId = $request->post['appId'];
        if ($appId && $this->appModel->removeImage($appId)) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //获取正在运行app
    function getRunningApp($request) {
        $host = $request->header['host'];
        $host = current(explode(":", $host));
        $outPut = [];
        $runningApp = $this->appModel->getRunningApp();
        if (in_array("WebSSH", $runningApp)) {
            $webSSH = true;
        } else {
            $webSSH = false;
        }
        foreach ($runningApp as $appName) {
            $config = $this->appModel->getAppConfig($appName);
            if ($config['httpPort']) {
                if (isset($config['httpsOnly']) && $config['httpsOnly']) {
                    $config['webUi'] = "https://" . $host . ":" . $config['httpPort'];
                } else {
                    $config['webUi'] = "http://" . $host . ":" . $config['httpPort'];
                }
            } else {
                $config['webUi'] = "";
            }
            if ($config['appPorts']) {
                $config['ports'] = implode(" ", $config['appPorts']);
            } else {
                $config['ports'] = "未开放";
            }
            if (!isset($config['auth']) || !$config['auth']) {
                $config['auth'] = "无";
            }
            if (!isset($config["appConfig"])) {
                $config["appConfig"] = "";
            }
            if ($webSSH) {
                $config["webSSH"] = 1;
            } else {
                $config["webSSH"] = 0;
            }
            $outPut[] = $config;
        }
        return (new \Lit\Ms\LitMsResponse())->success($outPut);
    }

    //删除app
    function removeApp($request) {
        $appId = $request->post['appId'];
        if ($appId && $this->appModel->removeApp($appId)) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //重启app
    function restartApp($request) {
        $appId = $request->post['appId'];
        if ($appId && $this->appModel->restartApp($appId)) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //清理无用镜像
    function cleanImage() {
        if ($this->dockerModel->cleanImage()) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //清理退出容器
    function cleanContainer() {
        if ($this->dockerModel->cleanContainer()) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //清理dockerStore产生的镜像
    function cleanDockerStoreImages() {
        if ($this->dockerModel->cleanDockerStoreImages()) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //获取配置文件列表
    function getConfigList($request) {
        $config = $this->appModel->getAppConfig($request->get['appId']);
        if ($config['appConfig']) {
            return (new \Lit\Ms\LitMsResponse())->success($config['appConfig']);
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //获取配置文件
    function getConfigContent($request) {
        $appId = $request->get['appId'];
        $config = $this->appModel->getAppConfig($appId);
        if ($config['appConfig']) {
            $configFile = $config['appConfig'][$request->get['fileId']];
            $configFileContent = $this->appModel->getAppFileContent($appId, $configFile["file"]);
            return (new \Lit\Ms\LitMsResponse())->success(["content" => $configFileContent]);
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //保存配置文件
    function saveConfigContent($request) {
        $appId = $request->post['appId'];
        $fileId = $request->post['fileId'];
        $content = $request->post['content'];
        $config = $this->appModel->getAppConfig($appId);
        if ($config['appConfig']) {
            $configFile = $config['appConfig'][$fileId];
            if ($this->appModel->saveConfigContent($appId, $configFile["file"], $content)) {
                return (new \Lit\Ms\LitMsResponse())->success();
            } else {
                return (new \Lit\Ms\LitMsResponse())->error();
            }
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //获取容器log
    function getAppLogs($request) {
        $appId = $request->get['appId'];
        $log = $this->appModel->getAppLogs($appId);
        if ($log) {
            return (new \Lit\Ms\LitMsResponse())->success(["content" => $log]);
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }

    //ssh链接
    function sshConnect($request, $response) {

        $appModel = $this->appModel;
        if (!in_array("WebSSH", $appModel->getRunningApp())) {
            return (new \Lit\Ms\LitMsResponse())->error(0, "必须先启动 WebSSH 服务才能使用此功能");
        }

        $action = $request->get["action"];
        $appId = $request->get['appId'];
        $host = $request->header['host'];
        $host = current(explode(":", $host));

        //先生成一个随机密码
        $pwd = uniqid() . rand(10000, 99999);
        $newCmd = "docker exec -it WebSSH bash -c 'echo dockerstore:{$pwd} | chpasswd'";
        exec($newCmd);

        //登录地址
        $passwd = base64_encode($pwd);
        if ($action == "ssh") {
            $command = "sudo docker exec -it {$appId} sh -c 'clear;sh' ";
        } elseif ($action == "build") {
            $appModel = $this->appModel;
            $dir = $appModel->getAppDir($appId);
            $buildCmd = $this->dockerModel->buildImage($dir, true);
            $buildCmd = str_replace("&&", ";", $buildCmd);
            $command = "sudo docker exec -it DockerStore bash -c '{$buildCmd}'";
        } else {
            $command = "ls";
        }
        $url = "https://" . $host . ":9112?hostname=127.0.0.1&username=dockerstore&password={$passwd}&command={$command}";

        //密码设为无效
        go(function () {
            $pwd = uniqid() . rand(10000, 99999);
            $newCmd = "sleep 2 && docker exec -it WebSSH bash -c 'echo dockerstore:{$pwd} | chpasswd'";
            co::exec($newCmd);
        });
        return (new \Lit\Ms\LitMsResponse())->string('<meta http-equiv="refresh" content="0; url=' . $url . '">');
    }

    //清理dockerStore产生的镜像
    function uninstallDockerStore() {
        if ($this->dockerModel->uninstallDockerStore()) {
            return (new \Lit\Ms\LitMsResponse())->success();
        } else {
            return (new \Lit\Ms\LitMsResponse())->error();
        }
    }
}