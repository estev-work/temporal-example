# syntax=docker/dockerfile:1.4

ARG PHP_VERSION=8.3

########################
#       BASE STAGE     #
########################
FROM php:${PHP_VERSION}-fpm-alpine AS base

# Устанавливаем необходимые пакеты для компиляции расширений (grpc, sockets, pdo_pgsql, xdebug и т.д.)
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

# Устанавливаем основные расширения PHP
RUN docker-php-ext-install pdo_pgsql sockets

# gRPC
RUN pecl install grpc \
    && docker-php-ext-enable grpc

# Настройка рабочего каталога
WORKDIR /var/www/html

########################
#    PRODUCTION STAGE  #
########################
FROM base AS production

# Здесь копируем исходники проекта внутрь контейнера
# (если используете volume - можете не копировать).
COPY . /var/www/html

# Устанавливаем правильные права (не всегда нужно, зависит от окружения)
RUN chown -R www-data:www-data /var/www/html

# Запускаем php-fpm
CMD ["php-fpm"]


########################
#      XDEBUG STAGE    #
########################
FROM base AS xdebug

# Устанавливаем Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
