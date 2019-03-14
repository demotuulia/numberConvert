# ----------------------------------------------------------------------------------
# Run mysql server
# ----------------------------------------------------------------------------------
# source https://docs.docker.com/samples/library/mysql/
#
# docker run --name tuulia-mysql-server -v  /Users/t.antonius/docker/tuuliaLamp/mysqlData:/var/lib/mysql  -e MYSQL_ROOT_PASSWORD=123 -d mysql
#
# Where /Users/t.antonius/docker/tuuliaLamp/mysqlData   is a directoy on your host machine
#                                                       to make data persitent.
#                                                       Remember to change the permission by : sudo chmod -R 777 /Users/t.antonius/docker/tuuliaLamp/mysqlData
# MYSQL_ROOT_PASSWORD                                   root password
#
#
# dump database (tuulia_test):
# docker exec tuulia-mysql-server sh -c 'exec mysqldump tuulia_test -uroot -p123' > tuulia_test.sql
#
# import the same dump:
# cat tuulia_test.sql | docker exec -i tuulia-mysql-server  /usr/bin/mysql -u root --password=123
#
#
#
# ----------------------------------------------------------------------------------
# Build and run tuulia_lamp
# ----------------------------------------------------------------------------------
# source https://github.com/kstaken/dockerfile-examples/blob/master/apache/Dockerfile
#
# build: docker build -t tuulia_lamp  .
# run:  docker run --rm --name=tuulia_test   --link tuulia-mysql-server:mysql -p 2222:80 -v /Users/t.antonius/docker/tuuliaLamp/:/var/www/html tuulia_lamp
# Where
#       2222                                    the port you want to open it in your local host
#       80                                      Apache port in the virtual machine
#       /Users/t.antonius/docker/tuuliaLamp/    Source folder in my host machine
#       var/www/html                            Source folder in the virtual machine
#        --link tuulia-mysql-server:mysql       Enables mysl connection in tuulia-mysql-server
#
#
# open in browser:  localhost:2222
#
# To ssh:
# docker exec -u 0 -it tuulia_test bash
# Get server ip:
# docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' container_id
#
# Retart apache:
# > /etc/init.d/apache2 reload
# ----------------------------------------------------------------------------------
# Connect to mysql server
# ----------------------------------------------------------------------------------
# Host machine:
#  docker run -it --link tuulia-mysql-server:mysql --rm mysql sh -c 'exec mysql -hIP_TUULIA_MYSQL_SERVER -P3306 -uroot -p123'
# In tuulia_test server:
# mysql -hIP_TUULIA_MYSQL_SERVER -uroot -p123
#
#
#
# ----------------------------------------------------------------------------------
# to kill
# ----------------------------------------------------------------------------------
# docker rm tuulia_test; docker kill tuulia_test;
# docker rm tuulia-mysql-server; docker kill tuulia-mysql-server;
#
#####################################################################################################


FROM ubuntu:18.04

MAINTAINER tuulia

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -yq --no-install-recommends \
    apt-utils \
    curl \
    # Install git
    git \
    # Install apache
    apache2 \
    # Install php 7.2
    libapache2-mod-php7.2 \
    php7.2-cli \
    php7.2-json \
    php7.2-curl \
    php7.2-fpm \
    php7.2-gd \
    php7.2-ldap \
    php7.2-mbstring \
    php7.2-mysql \
    php7.2-soap \
    php7.2-sqlite3 \
    php7.2-xml \
    php7.2-zip \
    php7.2-intl \
    php-imagick \
    # Install tools
    openssl \
    nano \
    graphicsmagick \
    imagemagick \
    ghostscript \
    mysql-client \
    iputils-ping \
    locales \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHPUnit
RUN apt-get update
RUN apt-get install wget -y
RUN wget https://phar.phpunit.de/phpunit-6.5.phar
RUN chmod +x phpunit-6.5.phar
RUN mv phpunit-6.5.phar /usr/local/bin/phpunit

#install vi
RUN apt-get update
RUN apt-get install vim -y


# change the apache root directory to /var/www/html/code/public
#
# in this way you have public folders in public and php code in code
# So that you can use a standard framework like Laravel
RUN mkdir -p /var/www/html/code/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/code/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf





# Install composer# s
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set locales
RUN locale-gen en_US.UTF-8 en_GB.UTF-8 de_DE.UTF-8 es_ES.UTF-8 fr_FR.UTF-8 it_IT.UTF-8 km_KH sv_SE.UTF-8 fi_FI.UTF-8


# Enble Apache rewrite module
RUN a2enmod rewrite
RUN mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

# allow .htacces override
#This is quick and dirtt= way because  we replace all "AllowOverride None" in /etc/apache2/apache2.conf
RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g'  /etc/apache2/apache2.conf

EXPOSE 80 443

WORKDIR /var/www/html/

#RUN rm index.html

CMD ["apache2ctl", "-D", "FOREGROUND"]




