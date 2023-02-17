FROM golang:latest as build

ARG RUNN_VERSION
ARG SQLDEF_VERSION

ENV ROOT=/go/src/app

RUN go install github.com/k1LoW/runn/cmd/runn@${RUNN_VERSION}
RUN go install github.com/k0kubun/sqldef/cmd/psqldef@${SQLDEF_VERSION}
RUN go install github.com/k0kubun/sqldef/cmd/mysqldef@${SQLDEF_VERSION}

FROM public.ecr.aws/docker/library/php:8.2.2-apache

ENV COMPOSER_HOME=/root/composer \
    PATH=$COMPOSER_HOME/vendor/bin:$PATH \
    COMPOSER_ALLOW_SUPERUSER=1 \
    DEBCONF_NOWARNINGS=yes

ARG USER_ID
ARG GROUP_ID
ARG USER_NAME

# package install and setup
RUN apt-get update \
 && groupadd -o -g ${GROUP_ID} ${USER_NAME} && useradd -o -u ${USER_ID} -g ${GROUP_ID} ${USER_NAME} \
 && mkdir -p /opt/projectWorkSpace/ && chown ${USER_NAME}:${USER_NAME} -R /opt/projectWorkSpace/ \
 && apt-get -y install iputils-ping net-tools git unzip less libzip-dev libicu-dev libonig-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libpq-dev \
 && pecl install redis xdebug \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-configure opcache --enable-opcache \
 && docker-php-ext-install gd pdo_pgsql pgsql opcache intl zip bcmath \
 && docker-php-ext-enable redis xdebug \
 && touch /tmp/xdebug.log && chmod 777 /tmp/xdebug.log \
 && apt-get clean && rm -rf /var/lib/apt/lists/* \
 && a2enmod rewrite

# php.ini
COPY ./docker/mac/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/mac/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./docker/mac/php/000-default.conf /etc/apache2/sites-available/000-default.conf

# php.conf
#COPY ./docker/mac/php/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

#COPY --chmod=0700 --chown=${UNAME}:${UNAME} ./src/storage /opt/projectWorkSpace/storage
COPY --from=public.ecr.aws/docker/library/composer:2.5.1 /usr/bin/composer /usr/bin/composer
COPY --from=build /go/bin/mysqldef /usr/bin/mysqldef
COPY --from=build /go/bin/psqldef /usr/bin/psqldef
COPY --from=build /go/bin/runn /usr/bin/runn

#USER ${UNAME}
