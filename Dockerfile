FROM php:8.3.0-cli

RUN apt-get update && \
    apt-get install -y \
        git \
        unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY .*php /app
COPY components /app
COPY assets /app
COPY composer.json /app

RUN composer install

CMD ["php -S", "0.0.0.0:8000"]
