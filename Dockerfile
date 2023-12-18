FROM php:8.3.0-apache

RUN apk add git unzip php-mysqli

RUN docker-php-ext-install mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

COPY . /var/www/html/.
