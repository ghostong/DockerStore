FROM registry.cn-hangzhou.aliyuncs.com/litosrc/swoole:7.2_4.4.8
EXPOSE 9100
RUN apt-get update && apt-get -y -q install docker.io
RUN curl -fsSL https://code.aliyun.com/lit/resource/raw/master/docker/docker-compose-Linux-1.24.1-x86_64 -o /usr/local/bin/docker-compose
RUN chmod 755 /usr/local/bin/docker-compose
WORKDIR /workdir
ADD ./ /workdir

CMD ["php","Server.php"]