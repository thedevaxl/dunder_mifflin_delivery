# Use the official PHP image based on Alpine
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk --no-cache add \
    git \
    curl \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    oniguruma-dev \
    zip \
    unzip \
    bash \
    icu-dev \
    libzip-dev \
    zlib-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring zip exif pcntl intl gd

# Create a group and a user using Alpine's tools
RUN addgroup -g 1000 laravel && \
    adduser -u 1000 -G laravel -h /home/laravel -s /bin/bash -D laravel

# Set the working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . .

# Adjust ownership and permissions
RUN chown -R laravel:laravel /var/www/html/vendor /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/vendor /var/www/html/storage /var/www/html/bootstrap/cache

# Switch to the new user
USER laravel

# Install Composer dependencies
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --prefer-dist --no-scripts --no-progress

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
