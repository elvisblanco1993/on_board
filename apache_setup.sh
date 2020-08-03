#!/bin/sh
sudo apt install php libapache2-mod-php php-mbstring php-xmlrpc php-soap php-gd php-xml php-cli php-zip php-bcmath php-tokenizer php-json php-pear apache2 composer npm mysql-server mysql-client php-mysql phpmyadmin supervisor redis php-redis;

sudo gedit /etc/apache2/apache2.conf
sudo gedit /etc/apache2/sites-enabled/000-default.conf

# <VirtualHost *:80>
#    ServerName thedomain.com
#    ServerAdmin webmaster@thedomain.com
#    DocumentRoot /home/elvis/Projects/NBOARD/public

#    <Directory /home/elvis/Projects/NBOARD>
#        AllowOverride All
#    </Directory>
#    ErrorLog ${APACHE_LOG_DIR}/error.log
#    CustomLog ${APACHE_LOG_DIR}/access.log combined
# </VirtualHost>

sudo chgrp -R www-data .
sudo chown -R $USER:www-data storage;
sudo chown -R $USER:www-data bootstrap/cache;
chmod -R 775 ./storage;
chmod -R 775 bootstrap/cache;

sudo a2enmod rewrite;
sudo systemctl restart apache2;

composer install;
npm install;

# Create the database
sudo mysql -u root -p;
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'bahia9397';
GRANT ALL PRIVILEGES ON *.* to 'root'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
CREATE DATABASE odb;
sudo service mysql restart;
# Add database connection settings on .env
# Configure email and other settings on .env

php artisan migrate;
php artisan db:seed;
