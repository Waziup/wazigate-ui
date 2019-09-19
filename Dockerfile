FROM ulsmith/alpine-apache-php7
#MAINTAINER Moji eskandari@fbk.eu

COPY . /app/public

RUN apk update && \
    apk add wget

