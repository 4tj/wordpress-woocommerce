FROM wordpress:latest

WORKDIR /var/www/html

COPY ./wp-content/ ./wp-content/
RUN chmod -R 755 ./wp-content/

COPY php-filesize.ini $PHP_INI_DIR/conf.d/