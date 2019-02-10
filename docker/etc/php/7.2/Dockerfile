FROM ubuntu:bionic

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update \
    && apt-get install -y \
    git \
    wget \
    curl \
    zip \
    unzip \
    sqlite3 \
    locales \
    supervisor \
    vim \
    software-properties-common

RUN apt-get install -y \
	php7.2 \
	php7.2-common \
	php-amqp \
	php-apcu \
	php-imagick \
	php-redis \
	php7.2-bcmath \
	php7.2-bz2 \
	php7.2-cgi \
	php7.2-cli \
	php7.2-curl \
	php7.2-dba \
	php7.2-dev \
	php7.2-enchant \
	php7.2-fpm \
	php7.2-gd \
	php7.2-gmp \
	php7.2-imap \
	php7.2-interbase \
	php7.2-intl \
	php7.2-json \
	php7.2-ldap \
	php7.2-mbstring \
	php7.2-mysql \
	php7.2-odbc \
	php7.2-opcache \
	php7.2-pgsql \
	php7.2-phpdbg \
	php7.2-pspell \
	php7.2-readline \
	php7.2-recode \
	php7.2-soap \
	php7.2-sqlite3 \
	php7.2-sybase \
	php7.2-tidy \
	php7.2-xml \
	php7.2-xmlrpc \
	php7.2-zip \
	php7.2-xsl

COPY ./php.ini /etc/php/7.2/fpm/php.ini
COPY ./php.ini /etc/php/7.2/cli/php.ini

RUN sed -i 's|listen = /run/php/php7.2-fpm.sock|listen = 9000|g' /etc/php/7.2/fpm/pool.d/www.conf
RUN sed -i 's/;daemonize = yes/daemonize = no/g' /etc/php/7.2/fpm/php-fpm.conf
RUN sed -i 's/;clear_env = no/clear_env = no/g' /etc/php/7.2/fpm/pool.d/www.conf

RUN mkdir -p /var/run/php

COPY ./xdebug.sh xdebug.sh
RUN chmod a+x xdebug.sh
RUN ./xdebug.sh

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail
RUN sed -i 's|;sendmail_path =|sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025|g' /etc/php/7.2/fpm/php.ini

RUN apt-get install -y \
	libfontconfig \
	zlib1g \
	libfreetype6 \
	libxrender1 \
	libxext6 \
	libx11-6
RUN curl -L -o wkhtmltopdf.tar.xz https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz
RUN tar -xf wkhtmltopdf.tar.xz
RUN mv wkhtmltox/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf
RUN chmod +x /usr/local/bin/wkhtmltopdf
RUN apt-get clean

RUN php -r "readfile('https://drupalconsole.com/installer');" > drupal.phar
RUN mv drupal.phar /usr/local/bin/drupal
RUN chmod +x /usr/local/bin/drupal

COPY supervisord.conf /etc/supervisord.conf
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
