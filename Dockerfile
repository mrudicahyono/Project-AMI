FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install intl pdo pdo_mysql mysqli curl \
    && a2enmod rewrite

COPY . /var/www/html/
WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-intl

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -i 's|/var/www/html|${APACHE_DOCUMENT_ROOT}|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80