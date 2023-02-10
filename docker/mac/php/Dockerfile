FROM golang:latest as build

ARG RUNN_VERSION
ARG SQLDEF_VERSION

ENV ROOT=/go/src/app

RUN go install github.com/k1LoW/runn/cmd/runn@${RUNN_VERSION}
RUN go install github.com/k0kubun/sqldef/cmd/psqldef@${SQLDEF_VERSION}
RUN go install github.com/k0kubun/sqldef/cmd/mysqldef@${SQLDEF_VERSION}

FROM public.ecr.aws/docker/library/php:8.2.0-fpm-buster

ENV COMPOSER_HOME=/root/composer \
    PATH=$COMPOSER_HOME/vendor/bin:$PATH \
    COMPOSER_ALLOW_SUPERUSER=1 \
    DEBCONF_NOWARNINGS=yes

# package install and setup
RUN apt-get update \
 && apt-get -y install iputils-ping net-tools git unzip less libzip-dev libicu-dev libonig-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libpq-dev \
 && pecl install redis \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-configure opcache --enable-opcache \
 && docker-php-ext-install gd pdo_pgsql pgsql opcache intl zip bcmath \
 && docker-php-ext-enable redis \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# xdebug install
ARG XDEBUG=false
RUN if [ "$XDEBUG" = true ]; then \
    pecl install xdebug \
     && docker-php-ext-enable xdebug \
     && touch /tmp/xdebug.log \
     && chmod 777 /tmp/xdebug.log; \
    fi

# project
ARG PROJECT_DOMAIN

# php.ini
COPY ./docker/mac/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/mac/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# php.conf
COPY ./docker/mac/php/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

COPY --chmod=0700 --chown=www-data:www-data ./src/storage /opt/projectWorkSpace/storage
COPY --from=public.ecr.aws/docker/library/composer:2.5.1 /usr/bin/composer /usr/bin/composer
COPY --from=node:18 /usr/local/bin/ /usr/local/bin/
COPY --from=node:18 /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=build /go/bin/mysqldef /usr/bin/mysqldef
COPY --from=build /go/bin/psqldef /usr/bin/psqldef
COPY --from=build /go/bin/runn /usr/bin/runn
