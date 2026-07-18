FROM dunglas/frankenphp:1-php8.4-alpine

RUN apk add --no-cache bash curl git unzip libpq-dev oniguruma-dev libxml2-dev libzip-dev zip libpng-dev libjpeg-turbo-dev freetype-dev icu-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_pgsql pgsql bcmath gd intl zip opcache && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-scripts --prefer-dist

COPY . .

RUN chmod +x /app/entrypoint.sh /app/Docker/entry.sh || true
RUN composer dump-autoload --optimize

ENV PORT=8000 HOST=0.0.0.0
EXPOSE 8000

ENTRYPOINT ["/bin/sh", "/app/entrypoint.sh"]