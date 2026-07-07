FROM php:8.4-fpm-alpine

RUN apk add --no-cache postgresql-dev nginx nodejs npm \
    && docker-php-ext-install pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && npm ci && npm run build \
    && rm -rf node_modules

COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD sh -c "php artisan migrate --force && php artisan config:cache && php-fpm & nginx -g 'daemon off;'"
