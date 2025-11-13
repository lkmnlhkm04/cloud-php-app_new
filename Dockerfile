FROM php:8.2-apache

# Salin semua file ke container
COPY . /var/www/html/
WORKDIR /var/www/html

# Install ekstensi mongodb terbaru dan composer
RUN apt-get update && apt-get install -y git unzip libssl-dev && \
    pecl install mongodb-1.17.0 && \
    docker-php-ext-enable mongodb && \
    curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install --ignore-platform-req=ext-mongodb

EXPOSE 80
CMD ["apache2-foreground"]
