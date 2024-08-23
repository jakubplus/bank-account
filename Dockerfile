# Use the official PHP image as the base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application code
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-interaction

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]