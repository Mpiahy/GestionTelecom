FROM php:8.1-fpm

# Installer les dépendances requises pour Composer
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les paquets nécessaires, y compris libpq-dev pour PostgreSQL
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    apt-transport-https \
    libpq-dev && \
    docker-php-ext-install pdo_pgsql
