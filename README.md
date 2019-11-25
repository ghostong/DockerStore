### 安装docker
    1. CentOS 查看 https://docs.docker.com/install/linux/docker-ce/centos/ 官方帮助文档 安装.
    2. Ubuntu 查看 https://docs.docker.com/install/linux/docker-ce/ubuntu/ 官方帮助文档 安装.
    3. 使用 docker -v 确认 Docker 是否安装成功.

### 安装项目
````bash
./dockerStore.sh install
````

### 更新项目
````bash
./dockerStore.sh update
````

### 启动项目
````bash
./dockerStore.sh start
````

### 关闭项目
````bash
./dockerStore.sh stop
````

### 配置
````bash
通过修改 dockerStore.sh 文件中的变量来实现配置

#Web端口 可直接加入IP, 进行IP访问限制, 例如 127.0.0.1:9100
PORT=9100

#用户名
USERNAME="dockerstore"

#密码
PASSWORD="dockerstore"
````

### 访问
    通过访问服务IP的 9100 端口(或者启动配置的端口) 访问服务.
    用户名密码为 配置项中的 USERNAME, PASSWORD
    默认用户名: dockerstore   密码: dockerstore