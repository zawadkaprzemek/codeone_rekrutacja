FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        git unzip libzip-dev libonig-dev libsqlite3-dev libicu-dev libssl-dev librabbitmq-dev libtool pkg-config \
    && docker-php-ext-install pdo pdo_sqlite zip intl sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --no-progress --prefer-dist

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
