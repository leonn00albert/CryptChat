FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    default-mysql-client   # Install MySQL client

RUN docker-php-ext-install pdo pdo_mysql mysqli gd intl zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files and seed.sql

# Set DocumentRoot to /var/www/html/
RUN sed -i 's#DocumentRoot /var/www/html/#DocumentRoot /var/www/html/#' /etc/apache2/sites-available/000-default.conf

# Disable server-generated directory indexes
RUN sed -i 's#Options Indexes FollowSymLinks#Options FollowSymLinks#' /etc/apache2/apache2.conf
RUN a2enmod rewrite
# Set correct file permissions
RUN chown -R www-data:www-data /var/www/html/

# Copy application files and seed.sql
COPY . /var/www/html/

COPY seed.sql /docker-entrypoint-initdb.d/seed.sql 

# Run Composer
RUN composer require cboden/ratchet

# Expose port
EXPOSE 8080
EXPOSE 80
