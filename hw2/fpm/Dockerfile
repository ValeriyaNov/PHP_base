FROM php:8.2-fpm

COPY ./php.ini /usr/local/ect/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD [ "php-fpm" ]