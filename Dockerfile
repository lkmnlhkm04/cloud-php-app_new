FROM php:8.2-cli

WORKDIR /app

# Install MongoDB extension
RUN apt-get update && apt-get install -y libssl-dev pkg-config && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

COPY . .

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000"]
