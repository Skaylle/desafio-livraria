FROM php:8.1-fpm

# Instala dependências do sistema
RUN apt-get update \
    && apt-get install -y \
        libpq-dev \
        libzip-dev \
        unzip \
        git \
        curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cria diretório da aplicação
WORKDIR /var/www/html

# Copia arquivos do projeto (exceto node_modules, vendor, etc)
COPY . /var/www/html

# Instala dependências do Laravel (se existir composer.json)
RUN if [ -f composer.json ]; then composer install --no-interaction --prefer-dist --optimize-autoloader; fi


# Permissões para o storage e cache (ignora erro se não existir)
RUN [ ! -d /var/www/html/storage ] || chown -R www-data:www-data /var/www/html/storage \
    && [ ! -d /var/www/html/bootstrap/cache ] || chown -R www-data:www-data /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
