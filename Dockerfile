FROM php:7.0.12-fpm

MAINTAINER Aliaksandr Harbunou <onekit@gmail.com>

# Install dependencies
RUN apt-get update && apt-get install -y
RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache

#its required for composer
RUN apt-get install -y git

# Copy application
ADD . /var/www/html

WORKDIR /var/www/html
CMD [ "php", "app/check.php" ]
