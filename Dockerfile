FROM php:8.2.12-alpine

RUN apt-get update && \
    apt-get install -y \
        git \
        unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . /app

RUN composer install

CMD ["php -S", "localhost:8000"]
