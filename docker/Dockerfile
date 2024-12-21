# Imagem base do PHP-FPM
FROM php:8.3-fpm

# Informações do autor
LABEL authors="Jhonattan Curtarelli"

# Atualiza o sistema e instala dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia o código-fonte para o container
COPY ./ /var/www/html

# Ajusta permissões da pasta de trabalho
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Define o diretório de trabalho
WORKDIR /var/www/html

# Comando principal para iniciar o PHP-FPM
CMD ["php-fpm"]
