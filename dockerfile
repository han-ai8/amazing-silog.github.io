# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install required PHP extensions (for MySQL, PDO, etc.)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Copy all project files to the Apache server root
COPY . /var/www/html/

# Set correct permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80 (default for HTTP)
EXPOSE 80