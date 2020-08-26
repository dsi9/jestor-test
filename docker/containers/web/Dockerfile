FROM php:7.3-fpm-alpine

RUN apk update

RUN apk --no-cache add shadow \
    php7 php7-fpm php7-json php7-openssl php7-curl php7-phar php7-iconv php7-mbstring php7-dom php7-xmlwriter \
    php7-tokenizer php7-xml \
    nginx nodejs supervisor curl git openssh \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN useradd -m app -G `whoami`

RUN chown -R app /run \
  && chown -R app /var/log/nginx \
  && chown -R app /var/lib/nginx

COPY docker/containers/web/nginx/etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/containers/web/php/etc/php7/php-fpm.d/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY docker/containers/web/php/etc/php7/conf.d/php.ini /etc/php7/conf.d/zzz_custom.ini
COPY docker/containers/web/supervisor/etc/supervisor/conf.d/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html

EXPOSE 8081

# Dependencies
RUN apk --no-cache add php7-pdo php7-pdo_mysql php7-pdo_dblib
RUN docker-php-ext-install pdo pdo_mysql

RUN apk --no-cache add npm

ENV PATH /app/node_modules/.bin:$PATH

USER app

EXPOSE 8082
EXPOSE 3000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
