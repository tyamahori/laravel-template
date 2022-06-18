FROM composer:2 as build

ENV DOCKERIZE_VERSION=v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
 && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
 && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

ENV SQLDEF_VERSION=v0.11.59
RUN /bin/sh -c 'set -ex && ARCH=`uname -m` && \
        if [ "$ARCH" == "aarch64" ]; then \
           echo "$ARCH" && wget https://github.com/k0kubun/sqldef/releases/download/$SQLDEF_VERSION/psqldef_linux_arm64.tar.gz \
            && tar -C /usr/local/bin -xzvf psqldef_linux_arm64.tar.gz \
            && rm psqldef_linux_arm64.tar.gz; \
        else \
           echo "$ARCH" && wget https://github.com/k0kubun/sqldef/releases/download/$SQLDEF_VERSION/psqldef_linux_386.tar.gz \
            && tar -C /usr/local/bin -xzvf psqldef_linux_386.tar.gz \
            && rm psqldef_linux_386.tar.gz; \
        fi'

FROM php:8.1-fpm-alpine3.15

ENV COMPOSER_HOME=/root/composer \
    PATH=$COMPOSER_HOME/vendor/bin:$PATH \
    COMPOSER_ALLOW_SUPERUSER=1 \
    DEBCONF_NOWARNINGS=yes

COPY --from=build /usr/bin/composer /usr/bin/composer
COPY --from=build /usr/local/bin/dockerize /usr/bin/dockerize

COPY --from=node:16-alpine3.13 /usr/local/bin/ /usr/local/bin/
COPY --from=node:16-alpine3.13 /usr/local/lib/node_modules /usr/local/lib/node_modules

COPY --from=build /usr/local/bin/psqldef /usr/bin/psqldef

# php.ini
COPY ./docker/mac/php/php.ini /usr/local/etc/php/php.ini
# php.conf
COPY ./docker/mac/php/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

# package install and setup
RUN set -eux \
 && apk add --update-cache --no-cache openssl git autoconf postgresql-dev libtool make gcc g++ libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev python3 postgresql-client \
 && pecl install redis \
 && docker-php-ext-configure gd --with-jpeg=/usr \
 && docker-php-ext-configure opcache --enable-opcache \
 && docker-php-ext-install gd pdo_pgsql pgsql opcache bcmath gd exif zip \
 && docker-php-ext-enable redis \
 && apk del autoconf g++ libtool make && rm -rf /tmp/*

# project
ARG PROJECT_DOMAIN
COPY ./src /opt/$PROJECT_DOMAIN
COPY --chown=www-data:www-data ./src/storage /opt/$PROJECT_DOMAIN/storage
