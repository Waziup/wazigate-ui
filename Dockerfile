FROM php:7.2-apache
MAINTAINER Moji eskandari@fbk.eu

RUN apt-get update -y && \
    apt-get install -y hugo git wget unzip

COPY . /var/www/html

#Fixing the permission issue
RUN chown -R www-data:www-data /var/www/html  && \
	chmod -R g+w /var/www/html && \
	usermod -u 1000 www-data
