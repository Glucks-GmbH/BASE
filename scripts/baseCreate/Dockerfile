# Dev
FROM php:7.4.1-apache AS base-template

# PHP

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Apache

RUN mkdir -p /var/www/html

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite
RUN a2enmod expires
RUN a2enmod headers
RUN a2enmod deflate
RUN a2enmod mime_magic

RUN apachectl restart