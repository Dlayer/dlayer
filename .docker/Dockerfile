FROM php:7.2-apache

COPY . /app/php
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /app

RUN docker-php-ext-install pdo_mysql \
    && chown -R www-data:www-data /app/php \
    && a2enmod rewrite
