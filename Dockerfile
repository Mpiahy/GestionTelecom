FROM php:8.1-fpm-alpine

# Installer les dépendances de base et Composer
RUN apk update && apk add --no-cache \
    curl \
    unzip \
    git \
    bash \
    postgresql-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && rm -rf /var/cache/apk/*  # Nettoyer les caches APK pour garder l'image légère

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    composer --version

# Vérifier si composer est installé
RUN ls -l /usr/local/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tout le projet d'abord (avant d'exécuter composer install)
COPY . .

# Copier composer.json et composer.lock en premier pour bénéficier du cache Docker
COPY composer.json composer.lock ./

# Installer les dépendances PHP via Composer
RUN composer install --optimize-autoloader --no-dev

# Vérifier la présence du fichier artisan et exécuter la commande key:generate uniquement si artisan est trouvé
RUN if [ -f artisan ]; then php artisan key:generate; else echo "artisan not found, skipping key:generate"; fi

# Configurer et installer les extensions PHP requises (comme GD, PDO, pdo_pgsql)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_pgsql

# Attribution des droits nécessaires pour les répertoires de stockage
RUN mkdir -p /var/www/html/storage /var/www/html/storage/logs /var/www/html/storage/framework /var/www/html/storage/cache \
    && chown -R www-data:www-data /var/www /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Lancer PHP-FPM
CMD ["php-fpm"]
