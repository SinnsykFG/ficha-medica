# Usa una imagen oficial de PHP con Apache y extensiones necesarias
FROM php:8.2-apache

# Instala dependencias del sistema y extensiones de PHP requeridas
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Habilita mod_rewrite de Apache (Laravel lo necesita)
RUN a2enmod rewrite

# Copia archivos del proyecto al contenedor
COPY . /var/www/html

# Establece directorio de trabajo
WORKDIR /var/www/html

# Instala Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Instala dependencias de Laravel
RUN composer install

# Da permisos de escritura
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80
EXPOSE 80
