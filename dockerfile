# Stage 1: Build stage
FROM php:8.2-cli AS builder

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy only the necessary files for installing dependencies
COPY composer.json composer.lock ./

# Install dependencies (no dev dependencies in production)
RUN composer install --no-scripts --no-autoloader --no-dev --optimize-autoloader

# Copy the rest of the application
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# Optimize the application
RUN php artisan optimize:clear \
    && php artisan optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Set proper permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Stage 2: Production stage
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    libwebp-tools \
    nginx \
    supervisor

# Install PHP extensions
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache \
    && apk del .build-deps

# Copy Nginx configuration
COPY docker/nginx/conf.d /etc/nginx/conf.d/

# Copy supervisor configuration
COPY docker/supervisor/conf.d /etc/supervisor/conf.d/

# Copy application from builder
COPY --from=builder /var/www/html /var/www/html

# Set working directory
WORKDIR /var/www/html

# Expose port 80 for Nginx
EXPOSE 80

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

# Start the application
ENTRYPOINT ["entrypoint.sh"]