FROM php:7.3.15-apache-stretch

RUN apt-get update
RUN apt-get install -y zlib1g-dev libicu-dev g++

# DB
RUN docker-php-ext-install mysqli pdo pdo_mysql

# INTL
RUN docker-php-ext-install intl

# ZIP
RUN apt-get install -y \
	libzip-dev \
	zip \
	&& docker-php-ext-configure zip --with-libzip \
	&& docker-php-ext-install zip

# GD
RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd



# XDebug
RUN pecl install xdebug-2.7.0

# Apache

RUN mkdir -p /var/www/html

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# PHP - XDebug
RUN echo "zend_extension = $(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_enable = on" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_autostart = off" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_port = 9000" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_handler = dbgp" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_connect_back = 0" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.remote_host = docker.for.mac.localhost" >> /usr/local/etc/php/php.ini

RUN echo "xdebug.profiler_enable = 0" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.profiler_enable_trigger = 1" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.profiler_output_dir = \"/xdebug\"" >> /usr/local/etc/php/php.ini
RUN echo "xdebug.profiler_output_name = cachegrind.out.%s" >> /usr/local/etc/php/php.ini

# PHP - Error Reporting
RUN echo "error_reporting = E_ALL & ~E_STRICT & ~E_DEPRECATED" >> /usr/local/etc/php/php.ini

# Apache Modules

RUN a2enmod rewrite
RUN a2enmod expires
RUN a2enmod headers
RUN a2enmod deflate
RUN a2enmod mime_magic

RUN apachectl restart