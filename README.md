    
### 环境准备
#### 安装docker
    1. CentOS 查看 https://docs.docker.com/install/linux/docker-ce/centos/ 官方帮助文档 安装.
    2. Ubuntu 查看 https://docs.docker.com/install/linux/docker-ce/ubuntu/ 官方帮助文档 安装.
    4. MacOS 查看 https://www.docker.com/products/docker-desktop
    5. 使用 docker -v 确认 Docker 是否安装成功.
#### MacOS 
    1. MacOS需要把 /Volumes 目录设置为 docker 挂载白名单.
#### Windows
    1. 暂不支持 Windows 操作系统.
    
### 下载启动文件
````bash
curl -S https://code.aliyun.com/litosrc/litraw/raw/master/DockerStore/dockerStore.sh > dockerStore.sh && chmod 755 dockerStore.sh && sudo mkdir -p /Volumes/DockerStore && sudo chown $(whoami) /Volumes/DockerStore
````

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