FROM php:8.1-fpm-alpine

RUN apk add --no-cache shadow openssl bash mysql-client nodejs npm git \
    && docker-php-ext-install pdo pdo_mysql

RUN echo "PS1='\s-\v \$PWD \$ '" >> /home/www-data/.bashrc \
    && usermod -u 1000 www-data

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
COPY --chown=1000:www-data ./docker/app/entrypoint.sh /docker/
COPY --chown=1000:www-data ./src/ .
ARG ENV
RUN rm -rf html && ln -s public html \
    && cp -vfa .env.$ENV .env \
    && rm -rf .env.*

RUN composer install \
    && chown -R 1000:www-data vendor

# Install supervisor
RUN apk add supervisor

# Added supervisor config
COPY ./docker/app/supervisor.conf /etc/supervisord.conf

RUN chown 1000:www-data .
USER www-data
EXPOSE 9000
VOLUME /var/www
CMD dockerize /docker/entrypoint.sh