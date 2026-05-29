# Stage 1: Build frontend assets
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Install PHP dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# Install dependencies, optimize autoloader, and omit dev packages
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize

# Stage 3: Final Production Image
FROM php:8.4-apache

# Install system dependencies and required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip bcmath pcntl \
    # Enable Apache mod_rewrite for Laravel URLs
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Update Apache document root to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy application code
COPY . /var/www/html

# Copy built vendor folder from Composer stage
COPY --from=vendor /app/vendor /var/www/html/vendor

# Copy built frontend assets from Node stage
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Ensure proper permissions and ownership
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]

