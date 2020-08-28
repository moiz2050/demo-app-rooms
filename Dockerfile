FROM php:7.4-fpm

WORKDIR /var/www
COPY ./src /var/www

#RUN docker-php-ext-install pdo pdo_mysql sockets

RUN apt-get update && apt-get -y install curl gnupg git wget unzip

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer global require hirak/prestissimo;