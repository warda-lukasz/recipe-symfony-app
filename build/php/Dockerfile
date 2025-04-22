FROM php:8.3-fpm

RUN apt-get update && apt-get install -y 

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
&& docker-php-ext-install \
    zip \
    intl \
    mysqli \
    pdo pdo_mysql

RUN echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory-limit.ini
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/app

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN mkdir -p /var/www/.composer && chown -R www-data:www-data /var/www/.composer
RUN chown -R www-data:www-data /var/www/app

USER www-data

ENV COMPOSER_HOME=/var/www/.composer
ENV COMPOSER_CACHE_DIR=/var/www/.composer/cache
