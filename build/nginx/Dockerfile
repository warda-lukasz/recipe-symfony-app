FROM nginx:latest
COPY ./default.conf /etc/nginx/conf.d/

RUN mkdir -p /etc/nginx/ssl
COPY ./certs/certificate.crt /etc/nginx/ssl/
COPY ./certs/private.key /etc/nginx/ssl/
