# Use official PHP image with Apache
FROM php:8.2-apache

# Enable mod_rewrite for Apache (optional, if needed for routing)
RUN a2enmod rewrite

# Copy your project files into the container
COPY webmetrix/ /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Expose port 80 for web access
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
