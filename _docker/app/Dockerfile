FROM php:8.2.0-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip unzip \
    git \
    && docker-php-ext-install pdo_pgsql pgsql bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY php.ini /usr/local/etc/php/conf.d/php.ini

# Установка Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www

CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]
