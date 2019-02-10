#! /bin/bash

PHPAPI=$(phpize -v | grep Zend\ M | grep -oE '([0-9]+)')

pecl install xdebug

echo "[xdebug]" >> /etc/php/7.2/cli/php.ini
echo "zend_extension = /usr/lib/php/$PHPAPI/xdebug.so" >> /etc/php/7.2/cli/php.ini
echo "xdebug.var_display_max_children = -1" >> /etc/php/7.2/cli/php.ini
echo "xdebug.var_display_max_data = -1" >> /etc/php/7.2/cli/php.ini
echo "xdebug.var_display_max_depth = 256" >> /etc/php/7.2/cli/php.ini
echo "xdebug.remote_enable=1" >> /etc/php/7.2/cli/php.ini
echo "xdebug.remote_connect_back=0" >> /etc/php/7.2/cli/php.ini
echo "xdebug.idekey=\"PHPSTORM\"" >> /etc/php/7.2/cli/php.ini
echo "xdebug.remote_port=9001" >> /etc/php/7.2/cli/php.ini
echo "xdebug.remote_host=\"172.254.254.254\"" >> /etc/php/7.2/cli/php.ini
echo "xdebug.remote_handler=dbgp" >> /etc/php/7.2/cli/php.ini

echo "[xdebug]" >> /etc/php/7.2/fpm/php.ini
echo "zend_extension = /usr/lib/php/$PHPAPI/xdebug.so" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.var_display_max_children = -1" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.var_display_max_data = -1" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.var_display_max_depth = 256" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.remote_enable=1" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.remote_connect_back=0" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.idekey=\"PHPSTORM\"" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.remote_port=9001" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.remote_host=\"172.254.254.254\"" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.remote_handler=dbgp" >> /etc/php/7.2/fpm/php.ini
echo "xdebug.remote_autostart=1" >> /etc/php/7.2/fpm/php.ini

