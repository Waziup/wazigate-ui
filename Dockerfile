FROM nimmis/alpine-apache-php7
#MAINTAINER Moji eskandari@fbk.eu

RUN apk update
RUN apk add php7-session 

COPY . /web/html

