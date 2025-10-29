# notifications-svc/Dockerfile
FROM php:8.3-cli

# Instalacja zależności systemowych
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    pkg-config \
    libzip-dev \
    libonig-dev \
    libssl-dev \
    librabbitmq-dev \
    libsqlite3-dev \
    libtool \
    && docker-php-ext-install pdo pdo_sqlite zip sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && rm -rf /var/lib/apt/lists/*

# Instalacja Composera
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Instalacja zależności PHP (jeśli brak composer.lock – kontynuuj mimo błędu)
RUN composer install --no-interaction --no-progress --prefer-dist || true

CMD ["php", "consumer.php"]
