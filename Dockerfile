FROM wordpress:latest

COPY ./plugins /var/www/html/wp-content/plugins/
COPY ./themes /var/www/html/wp-content/themes/