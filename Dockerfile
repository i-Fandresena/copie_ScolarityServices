   FROM php:8.1-fpm
# Install required PHP extensions and libraries
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql intl gd exif zip
# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory for the application
WORKDIR /var/www/html

# Copy the Laravel application files to the container
COPY . .

# Install the Laravel application dependencies
RUN composer install --no-interaction --no-plugins --no-scripts

# Copy the configuration file for the application
COPY .env.example .env

# Generate a new application key
RUN php artisan key:generate

# Set permissions for the storage and bootstrap/cache directories
RUN chown -R www-data:www-data storage bootstrap/cache

# Set up the configuration file for PHP-FPM
#COPY docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

# Install MariaDB
RUN apt-get update && apt-get install -y mariadb-server nano vim

# Copy the MariaDB configuration file to the container
#COPY docker/mariadb/my.cnf /etc/mysql/my.cnf

# Set the root password for MariaDB
ENV MYSQL_ROOT_PASSWORD=""

# Expose ports for the application and MariaDB
EXPOSE 8000 3306 3000 9090

# Start the PHP-FPM and MariaDB services
CMD ["service mariadb start && php-fpm"]
