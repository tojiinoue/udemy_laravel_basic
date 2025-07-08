FROM php:8.2-apache

# 必要なPHP拡張をインストール
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravelアプリをコンテナにコピー
COPY . /var/www/html
WORKDIR /var/www/html

# Laravelの依存パッケージインストールと権限設定
RUN composer install --no-dev --optimize-autoloader \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# ApacheのDocumentRootを public に変更し、.htaccess 有効化（mod_rewrite）
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>\n\tAllowOverride All\n</Directory>' >> /etc/apache2/apache2.conf \
    && a2enmod rewrite

# Laravelの設定キャッシュ削除（.env反映のため）
RUN php artisan config:clear

EXPOSE 80
CMD ["apache2-foreground"]
