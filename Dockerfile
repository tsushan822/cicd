FROM php:7.4-fpm

RUN apt-get update && \
  DEBIAN_FRONTEND=noninteractive apt-get install -y \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libbz2-dev \
    cron \
    unzip \
    git \
    libxml2-dev \
    npm \
    vim \
    supervisor \
    && pecl channel-update pecl.php.net \
    && pecl install apcu

RUN apt-get install -y libzip-dev

#RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN mkdir -p /var/www/html

WORKDIR /var/www/html/

COPY ./ /var/www/html

COPY ./docker/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

RUN docker-php-ext-install pdo pdo_mysql soap zip gd

#installing Composers
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN composer update

RUN chmod -R 777 /var/www/html/storage

#RUN php artisan key:gen

RUN npm install npm@latest -g cross-env

RUN npm cache clean --force

#RUN npm run dev

EXPOSE 9000
