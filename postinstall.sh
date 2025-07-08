#!/bin/bash

# 本番環境で artisan コマンドを実行する
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --force
