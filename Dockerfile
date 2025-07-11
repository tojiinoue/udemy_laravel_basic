FROM php:8.2-apache

# PHP拡張インストール（PostgreSQLドライバを追加！）
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libonig-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip


# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ
WORKDIR /var/www/html

# アプリケーションのコピー
COPY . .

# 先に composer install する（--no-scripts は任意）
RUN composer install --no-dev --optimize-autoloader --no-scripts

# その後 artisan コマンドを実行する
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan optimize


# ストレージ/logs の作成とパーミッション調整
RUN mkdir -p storage/logs \
    && chown -R www-data:www-data storage \
    && chmod -R 775 storage \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage


# Apacheの設定
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
&& echo '<Directory /var/www/html/public>\n\tAllowOverride All\n</Directory>' >> /etc/apache2/apache2.conf

# ポート公開
EXPOSE 80

# 起動時に Laravel セットアップ → Apache 起動
CMD ["sh", "-c", "composer install --no-dev --optimize-autoloader && php artisan config:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && apache2-foreground"]
