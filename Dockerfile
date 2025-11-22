FROM php:8.2-apache

WORKDIR /var/www/html

# Install OS dependencies
RUN apt-get update && \
    apt-get install -y git unzip libssl-dev pkg-config ca-certificates --no-install-recommends && \
    rm -rf /var/lib/apt/lists/*

# Install MongoDB extension (correct version 1.18.1)
RUN pecl clear-cache && \
    yes "" | pecl install mongodb-1.18.1 && \
    docker-php-ext-enable mongodb

# Copy project files
COPY . /var/www/html

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Delete vendor folder (if exists) and reinstall
RUN rm -rf /var/www/html/vendor && \
    COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Fix Apache "ServerName" warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80
CMD ["apache2-foreground"]
