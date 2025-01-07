FROM php:8.3-fpm

LABEL authors="Jhonattan Curtarelli"

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./ /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html

CMD ["php-fpm"]
