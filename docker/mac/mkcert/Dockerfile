FROM golang:alpine as build
ENV ROOT=/go/src/
WORKDIR /root
RUN apk update && apk add git nss && git clone https://github.com/FiloSottile/mkcert && cd mkcert && \
    go build -o /bin/mkcert -ldflags "-X main.Version=$(git describe --tags)"
