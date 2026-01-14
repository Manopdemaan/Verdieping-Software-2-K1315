# You can switch to another base (like php:8.2-fpm-alpine) if you prefer.
FROM php:8.3-fpm

# Install the PCNTL extension (plus pdo_mysql, etc.)
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql

# Enable/Install PCNTL
RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl


# Install PHP Redis extension via PECL
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer (pulling from official Composer image to copy the binary)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy in custom configuration files
COPY ./docker/webserver/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/webserver/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Make a new group/user (so we don't run everything as root in the container)
RUN groupadd -g 1000 laravel && \
    useradd -u 1000 -g 1000 -m laravel

# Set working directory
WORKDIR /var/www/html

# Ensure correct ownership
RUN chown -R laravel:laravel /var/www/html

# Expose the port that Nginx is listening on
EXPOSE 9003

# Switch to non-root user for runtime
#USER laravel

# By default, start Supervisord (which will spawn Nginx, PHP-FPM, and Horizon)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
