FROM php:8.3.0-apache

RUN apt-get update && apt-get install git unzip -y

RUN docker-php-ext-install mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/.

RUN composer install
