FROM php:8.1.0-fpm

WORKDIR /app

RUN apt-get update

RUN apt-get -y install git zip libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

ARG USER_ID=1000
RUN groupadd --gid "$USER_ID" admin \
    && useradd --uid "$USER_ID" -g www-data admin --create-home \
#CMD ["php-fpm"]