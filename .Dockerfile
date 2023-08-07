FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libzip-dev \
    unzip \
    git

RUN docker-php-ext-install pdo pdo_mysql mysqli gd intl zip

COPY app/ /var/www/html/

RUN composer require cboden/ratchet

EXPOSE 8080
