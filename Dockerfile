FROM php:8.2-apache

RUN a2enmod rewrite

# Allow .htaccess overrides in /var/www/
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Install PDO MySQL and MySQLi extensions, along with git, unzip, zip, and cron for scheduled tasks
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    cron \
    && docker-php-ext-install pdo_mysql mysqli

# Copy Composer into the container
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy cron configuration file
COPY crontab /etc/cron.d/reminder-cron

# Set correct permissions for cron file
RUN chmod 0644 /etc/cron.d/reminder-cron

# Create log file for cron output
RUN touch /var/log/cron.log

# Copy existing entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]