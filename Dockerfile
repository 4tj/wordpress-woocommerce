FROM wordpress:fpm-alpine

COPY ./plugins /var/www/html/wp-content/plugins/
COPY ./themes /var/www/html/wp-content/themes/
COPY php-fix-filesize.ini $PHP_INI_DIR/conf.d/