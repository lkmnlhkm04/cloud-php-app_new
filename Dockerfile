FROM php:8.2-apache

COPY . /var/www/html/
WORKDIR /var/www/html

# Hapus cache dulu, lalu paksa build ekstensi mongodb terbaru dari source
RUN apt-get update && apt-get install -y git unzip libssl-dev && \
    pecl clear-cache && \
    yes "" | pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install --ignore-platform-req=ext-mongodb

EXPOSE 80
CMD ["apache2-foreground"]
