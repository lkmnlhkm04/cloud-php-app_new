FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libssl-dev pkg-config && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# Copy project files
COPY . /var/www/html/
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --ignore-platform-req=ext-mongodb

EXPOSE 80
CMD ["apache2-foreground"]
