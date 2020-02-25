### 环境准备
#### 安装docker
    1. CentOS 查看 https://docs.docker.com/install/linux/docker-ce/centos/ 官方帮助文档 安装.
    2. Ubuntu 查看 https://docs.docker.com/install/linux/docker-ce/ubuntu/ 官方帮助文档 安装.
    3. MacOS 查看 https://www.docker.com/products/docker-desktop
    4. 使用 docker -v 确认 Docker 是否安装成功.

### 下载启动文件
````bash
curl -S https://code.aliyun.com/litosrc/DockerStore/raw/master/Docker/DockerStore/dockerStore.sh > dockerStore.sh && chmod 755 dockerStore.sh && sudo mkdir -p /Volumes/DockerStore && sudo chown $(whoami) /Volumes/DockerStore
````

### 特别注意
#### MacOS 
    1. MacOS 需要把 /Volumes 目录设置为 docker 挂载白名单.
    2. MocOS 需要使用如下命令配置ACL权限:  
````bash 
#配置ACL权限
sudo chmod  -R +a "$(whoami) allow write,delete,file_inherit,directory_inherit,add_subdirectory" /Volumes/DockerStore
````
#### Windows
    1. 暂不支持 Windows 操作系统.

### 安装项目
````bash
./dockerStore.sh install
````

### 最小安装
````bash
./dockerStore.sh fastinstall
````

### 更新基础镜像
````bash
./dockerStore.sh update
````

### 升级APP
````bash
./dockerStore.sh upgrade
````

### 启动项目
````bash
./dockerStore.sh start
````

### 关闭项目
````bash
./dockerStore.sh stop
````

### 重启项目
````bash
./dockerStore.sh restart

### 构建单个APP
./dockerStore.sh build MySQL75

````

### 配置
````bash
通过增加 .dockerStoreConf 文件配置启动参数

#Web端口 可直接加入IP, 进行IP访问限制, 例如 https://127.0.0.1:9100
PORT=9100

#用户名
USERNAME="dockerstore"

#密码
PASSWORD="dockerstore"
````

### 访问
    1. 通过 https 协议访问服务IP的 9100(默认) 端口(或者启动配置的端口) 访问服务
    2. 本机部署可以使用: https://dockerstore.ssh2.cc 域名访问, 此域名指向 127.0.0.1 
    3. DockerStore 默认的ssl证书域名为: https://dockerstore.ssh2.cc 可以自行更改hosts文件指向部署服务器IP来实现 https 访问
    4. IP 访问https 会报证书错误, 至文档编写日期 2020-01-16 , 所有的浏览器都可以直接强制信任后访问服务
    5. 用户名密码为 配置项中的 USERNAME, PASSWORD , 默认用户名: dockerstore   密码: dockerstore