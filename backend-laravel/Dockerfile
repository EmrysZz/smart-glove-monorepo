# Use an official PHP image with the Apache web server
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies
# We need git, zip/unzip, and libraries for common PHP extensions.
# We also install Node.js and npm to build the frontend assets.
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    nodejs \
    npm

# Install PHP extensions that Laravel needs
RUN docker-php-ext-install pdo_mysql zip

# Install Composer (PHP package manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy dependency files and install vendors to leverage Docker cache
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader

# Copy the rest of the application files
COPY . .

# Run the rest of the composer install scripts
RUN composer install --no-dev --no-interaction

# Install Node.js dependencies and build frontend assets
RUN npm install
RUN npm run build

# Set correct permissions for storage and cache so Apache can write to them
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy our custom Apache configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache's rewrite module for pretty URLs
RUN a2enmod rewrite

# Expose port 80 to the outside world
EXPOSE 80
