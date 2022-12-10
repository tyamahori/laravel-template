FROM public.ecr.aws/docker/library/composer:2.4.4 as build

ENV DOCKERIZE_VERSION=v0.15.0
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

FROM public.ecr.aws/docker/library/php:8.2.0-fpm-buster

ENV COMPOSER_HOME=/root/composer \
    PATH=$COMPOSER_HOME/vendor/bin:$PATH \
    COMPOSER_ALLOW_SUPERUSER=1 \
    DEBCONF_NOWARNINGS=yes

COPY --from=build /usr/bin/composer /usr/bin/composer
COPY --from=build /usr/local/bin/dockerize /usr/bin/dockerize

COPY --from=node:18 /usr/local/bin/ /usr/local/bin/
COPY --from=node:18 /usr/local/lib/node_modules /usr/local/lib/node_modules

COPY --from=build /usr/local/bin/psqldef /usr/bin/psqldef

# php.ini
COPY ./docker/mac/php/php.ini /usr/local/etc/php/php.ini
# php.conf
COPY ./docker/mac/php/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

# package install and setup
RUN apt-get update \
 && apt-get -y install git unzip less libzip-dev libicu-dev libonig-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libpq-dev \
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
COPY --chown=www-data:www-data ./src/storage /opt/$PROJECT_DOMAIN/storage
