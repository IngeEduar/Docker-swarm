FROM php:8.1-apache

WORKDIR /var/www/html/

COPY /app/ /var/www/html/

RUN apt-get update && apt-get install -y  git unzip

RUN apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN composer install

ENV DATABASE_URL="mysql://root:root@my-api_db:3306/bdejempl2?serverVersion=10.9.3-MariaDB"

EXPOSE 8000

CMD ["symfony", "server:start"]