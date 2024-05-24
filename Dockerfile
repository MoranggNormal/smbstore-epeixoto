FROM php:7.4-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite

COPY ./src /var/www/html/

WORKDIR /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

COPY ./docker/apache/apache-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80 8080