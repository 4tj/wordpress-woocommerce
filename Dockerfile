FROM wordpress:latest

COPY ./plugins/ /var/www/html/wp-content/plugins/
COPY ./themes/ /var/www/html/wp-content/themes/

RUN "echo 'ServerName 0.0.0.0' >> /etc/apache2/apache2.conf && echo 'DirectoryIndex index.php index.html' >> /etc/apache2/apache2.conf && echo 'upload_max_filesize = 50M' >> /usr/local/etc/php/php.ini && echo 'post_max_size = 50M' >> /usr/local/etc/php/php.ini"

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]