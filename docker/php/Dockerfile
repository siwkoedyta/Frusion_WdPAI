FROM php:8.2.11-fpm-alpine3.18

RUN apk --no-cache add postgresql-dev \
    && docker-php-ext-install pdo_pgsql

# Copy the application code
COPY . /app

VOLUME ["/app"]
