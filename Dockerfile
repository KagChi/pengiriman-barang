FROM php:8.3.0-alpine

RUN apk add git unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install

CMD ["php -S", "0.0.0.0:8000"]
