### 安装docker
    1. CentOS 查看 https://docs.docker.com/install/linux/docker-ce/centos/ 官方帮助文档 安装.
    2. Ubuntu 查看 https://docs.docker.com/install/linux/docker-ce/ubuntu/ 官方帮助文档 安装.
    3. 使用 docker -v 确认 Docker 是否安装成功.

### 安装项目
````bash
docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest php Server.php install
````

### 启动项目
````bash
docker run -itd \
    -v /var/run/docker.sock:/var/run/docker.sock \
    -p 9100:9100 \
    --env USERNAME="username" \
    --env PASSWORD="password" \
    --name DockerStore \
    registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest
````

### 访问
    通过访问服务IP的 9001端口(或者启动自定义端口) 访问服务.
    用户名密码为 启动项目 步骤中的环境变量