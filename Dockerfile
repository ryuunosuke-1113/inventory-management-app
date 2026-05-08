FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nginx \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    nodejs \
    npm \
    netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ← これ超重要
COPY . .

RUN cd src && composer install --no-dev --optimize-autoloader
RUN cd src && npm install
RUN cd src && npm run build

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN rm /etc/nginx/sites-enabled/default
COPY scripts/start.sh /start.sh
RUN chmod +x /start.sh
RUN chmod -R 777 /var/www
CMD ["/start.sh"]