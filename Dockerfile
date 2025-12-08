# Utiliser PHP 8.2 avec FPM
FROM php:8.2-fpm

# Installer les dépendances systèmes nécessaires
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpng-dev libonig-dev libxml2-dev libpq-dev libjpeg-dev libfreetype6-dev \
    postgresql-client \
    && rm -rf /var/lib/apt/lists/*

# Configurer GD avec JPEG/Freetype
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le projet
COPY . .

# Installer les dépendances Laravel
RUN composer install --optimize-autoloader --no-dev

# Donner les bonnes permissions aux dossiers storage et cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port
EXPOSE 8000

# Démarrer Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
