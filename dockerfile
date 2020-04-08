FROM registry.cn-hangzhou.aliyuncs.com/litosrc/php7-swoole:latest
EXPOSE 9100
RUN apt-get update && apt-get -y -q install docker.io
WORKDIR /tmp
ADD ./Dependence/docker-compose-Linux-x86_64 /usr/local/bin/docker-compose
RUN chmod 755 /usr/local/bin/docker-compose
WORKDIR /workdir
ADD ./Model Model
ADD ./SSL SSL
ADD ./Static Static
ADD ./vendor vendor
ADD ./View View
ADD ./Controller.php Controller.php
ADD ./Filter.php Filter.php
ADD ./OnStart.php OnStart.php
ADD ./Server.php Server.php
ADD ./App App

CMD ["php","Server.php"]