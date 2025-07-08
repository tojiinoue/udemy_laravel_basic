FROM php:8.2-apache

# 必要なPHP拡張をインストール
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel用のApache設定
COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# ApacheのDocumentRoot変更
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN php artisan config:clear


EXPOSE 80
CMD ["apache2-foreground"]
