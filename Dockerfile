FROM php:8.3.0-apache

RUN apt-get install git unzip php-mysqli -y

RUN docker-php-ext-install mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

COPY . /var/www/html/.
