#FROM golang:latest as build
#ENV ROOT=/go/src/app
#
#RUN apt-get update && git clone https://github.com/FiloSottile/mkcert && cd mkcert && \
#    go build -o /usr/bin/mkcert -ldflags "-X main.Version=$(git describe --tags)"

FROM ubuntu:22.04
ENV LC_ALL C.UTF-8
RUN apt-get update && \
    apt-get install -y libnss3-tools openssh-server iputils-ping net-tools curl && \
    mkdir -p /root/.ssh && \
    rm -rf /var/lib/apt/lists/* && \
    echo "root:root" | chpasswd && \
    sed -i "s/#PermitRootLogin prohibit-password/PermitRootLogin yes/" /etc/ssh/sshd_config

COPY --chmod=0600 ./authorized_keys /root/.ssh/authorized_keys

#COPY --from=build /usr/bin/mkcert /usr/bin/mkcert
#RUN mkdir -p /var/www/ssl && cd /var/www/html \
#    && mkcert -key-file ./key.pem -cert-file ./cert.pem "tyamahori.love" "*.tyamahori.love" \
#    && mkcert -install

EXPOSE 22
CMD service ssh start && /bin/bash
