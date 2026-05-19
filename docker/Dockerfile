FROM crinabarbieru/wordpress-vulnerable:latest

COPY plugins/simple-basic-contact-form /var/www/html/wp-content/plugins/simple-basic-contact-form
COPY plugins/wp-stripe-donation /var/www/html/wp-content/plugins/wp-stripe-donation

# Update WordPress core to latest
USER root
RUN apt-get update && apt-get install -y curl \
    && curl -o /tmp/wordpress.tar.gz https://wordpress.org/latest.tar.gz \
    && tar -xzf /tmp/wordpress.tar.gz -C /tmp \
    && cp -rf /tmp/wordpress/wp-admin /var/www/html/ \
    && cp -rf /tmp/wordpress/wp-includes /var/www/html/ \
    && cp /tmp/wordpress/*.php /var/www/html/ \
    && rm -rf /tmp/wordpress /tmp/wordpress.tar.gz \
    && apt-get remove -y curl && apt-get autoremove -y && apt-get clean