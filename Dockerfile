FROM php:8.3.0-alpine

RUN apk add git unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

CMD ["/usr/local/bin/php", "0.0.0.0:8000"]
