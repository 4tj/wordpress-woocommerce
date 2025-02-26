FROM wordpress:latest

COPY ./plugins/ /usr/src/wordpress/wp-content/plugins/
COPY ./themes/ /usr/src/wordpress/wp-content/themes/
COPY php-filesize.ini $PHP_INI_DIR/conf.d/