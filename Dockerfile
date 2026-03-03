FROM php:8.2-apache

RUN a2enmod rewrite

# Allow .htaccess overrides in /var/www/
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Install PDO MySQL driver (and mysqli is handy too)
RUN docker-php-ext-install pdo_mysql mysqli