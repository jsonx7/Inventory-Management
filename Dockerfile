# ---------- Etapa 1: build del frontend ----------
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---------- Etapa 2: aplicación ----------
FROM serversideup/php:8.3-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1
ENV AUTORUN_ENABLED=true
ENV AUTORUN_LARAVEL_MIGRATION=true
ENV AUTORUN_LARAVEL_STORAGE_LINK=true

USER root
RUN install-php-extensions pdo_mysql

WORKDIR /var/www/html
COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build

USER www-data
RUN composer install --no-dev --optimize-autoloader --no-interaction
