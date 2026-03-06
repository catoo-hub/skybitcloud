FROM node:20 AS node_build
WORKDIR /app
ENV npm_config_include=optional
ENV NAPI_RS_FORCE_WASI=1
COPY package.json package-lock.json* ./
RUN npm ci --include=optional --no-audit --no-fund \
    || (rm -rf node_modules package-lock.json && npm install --include=optional --no-audit --no-fund)
RUN npm rebuild @tailwindcss/oxide --no-audit --no-fund || true
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

FROM serversideup/php:8.4-fpm-nginx AS production

ENV PHP_OPCACHE_ENABLE=1

WORKDIR /var/www/html

# Копируем файлы проекта
COPY --chown=www-data:www-data . .

# Копируем собранные ассеты из node_build
COPY --from=node_build --chown=www-data:www-data /app/public/build ./public/build

# Устанавливаем зависимости Composer
USER www-data
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Создаем структуру папок storage, так как они игнорируются в .dockerignore
USER root
RUN mkdir -p storage/framework/views \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/testing \
    storage/logs \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data
