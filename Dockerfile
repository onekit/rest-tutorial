FROM php:7-fpm

MAINTAINER Aliaksandr Harbunou "onekit@gmail.com"

ENV HOME /app

# Install modules
RUN apt-get update && apt-get install -y \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
	libicu-dev \
	mysql-client && \
	docker-php-ext-install mcrypt && \
	docker-php-ext-install intl && \
    docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-install exif && \
    ## APCu
    pecl install apcu && \
    docker-php-ext-enable apcu

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

WORKDIR /app

## Install Composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=. --filename=composer.phar

COPY . ./
RUN php composer.phar install --optimize-autoloader