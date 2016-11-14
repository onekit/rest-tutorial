FROM php:7-fpm


# Install modules
RUN apt-get update && apt-get install -y \
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
    docker-php-ext-install exif


RUN apt-get update && apt-get install -y \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

## Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer
## https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN mkdir /tmp/cache
RUN mkdir /tmp/logs
RUN mkdir /tmp/logs/dev
RUN mkdir /tmp/cache/dev
RUN mkdir /tmp/cache/jms_diextra
RUN mkdir /tmp/cache/jms_diextra/metadata
RUN chmod 777 -R /tmp
#
#RUN php --version
#
#ADD . /app
#WORKDIR /app
#RUN composer update