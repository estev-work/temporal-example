# syntax=docker/dockerfile:1.4

ARG PHP_VERSION=8.4

########################
#       BASE STAGE     #
########################
FROM php:${PHP_VERSION}-fpm-alpine AS base

RUN apk add --no-cache autoconf make g++ linux-headers zlib-dev \
    postgresql-dev  \
    openssl-dev  \
    icu-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev \
    curl \
    protobuf-dev \
    grpc-dev \
    git

RUN docker-php-ext-install pdo_pgsql sockets

RUN pecl install grpc \
    && docker-php-ext-enable grpc

WORKDIR /var/www/html

########################
#    PRODUCTION STAGE  #
########################
FROM base AS production
COPY ./php-src /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Установка Composer
COPY --from=composer/composer:2.5-bin /composer /usr/bin/composer

CMD ["php-fpm"]

########################
#      XDEBUG STAGE    #
########################
FROM base AS xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Копируем файл конфигурации xdebug.ini
COPY ./docker/php/xdebug/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY ./php-src /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Установка Composer
COPY --from=composer/composer:2.5-bin /composer /usr/bin/composer

CMD ["php-fpm"]
