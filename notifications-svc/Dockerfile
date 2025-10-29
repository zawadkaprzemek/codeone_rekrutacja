FROM php:8.3-cli

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

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-interaction --no-progress --prefer-dist || true

CMD ["php", "consumer.php"]
