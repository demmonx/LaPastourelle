FROM ubuntu:14.04
COPY docker/entrypoint.sh /usr/local/bin/

VOLUME ["/var/www"]
VOLUME ["/install"]

# Install php + apache to serve vscode
RUN apt-get update && \
    apt-get dist-upgrade -y && \
    apt-get install -y \
      apache2 \
      php5 \
      php5-cli \
      libapache2-mod-php5 \
      php5-mysql \
      php5-pgsql \
      postgresql-client \
      vim

RUN a2enmod rewrite
COPY docker/apache-default /etc/apache2/sites-available/000-default.conf

EXPOSE 80
ENTRYPOINT ["entrypoint.sh"]
