FROM php:7.2-fpm

RUN apt-get update \
    && docker-php-ext-install -j$(nproc) \
        mbstring \
        pdo \
        pdo_mysql \
