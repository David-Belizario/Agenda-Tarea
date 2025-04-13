FROM php:8.2-apache

# Instalar librerías del sistema y extensiones de PHP + Node.js y npm
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql zip

# Copiar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto Laravel al contenedor
COPY . /var/www/html/

# Establecer permisos necesarios en storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar DocumentRoot a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Habilitar mod_rewrite para las rutas de Laravel
RUN a2enmod rewrite

# Cambiamos el directorio de trabajo a /var/www/html
WORKDIR /var/www/html

# Instalar dependencias de Composer sin paquetes de desarrollo
RUN composer install --no-dev --optimize-autoloader

# Ejecutar migraciones (opcional; si la DB está accesible durante el build)
RUN php artisan migrate --force

# Instalar dependencias de Node y compilar con Vite
RUN npm install
RUN npm run build

# Exponer el puerto 80 (Apache)
EXPOSE 80

# Iniciar Apache en primer plano
CMD ["apache2-foreground"]
