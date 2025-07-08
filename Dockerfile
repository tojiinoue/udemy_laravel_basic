# ベースイメージ（PHP + Apache）
FROM php:8.2-apache

# 必要なPHP拡張のインストール
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring zip

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# Laravelアプリケーションのコピー
COPY . .

# パーミッションの設定
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Laravelのセットアップ
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Apacheの設定
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && echo '<Directory /var/www/html/public>\n\tAllowOverride All\n</Directory>' >> /etc/apache2/apache2.conf

# ポート公開
EXPOSE 80

# 起動コマンド
# CMD ["apache2-foreground"]
CMD tail -f storage/logs/laravel.log


