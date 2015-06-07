PngWidget
=========

A Symfony project created on June 7, 2015, 12:26 pm.


# Install

Create the Database and the table or import `pngwidgetrender.sql` :

    • $php app/console doctrine:mapping:
    • $php app/console doctrine:schema:update
Run Server:

    • $php app/console server:run
 	
### Create users  (CRUD)
	•http://127.0.0.1:8000/web/app_dev.php/user/
# Render PNG Image

    •http://127.0.0.1:8000/web/app_dev.php/{hash}/w{width}-h{height}-b{background}-t{textColor}

Example :

    •http://127.0.0.1:8000/web/app_dev.php/09a50fd6acdf3983da36988c804ae041/w100-h100-bC74343-tECF019
    
## Tests

    • phpunit -c app/

To add a local host name please create :

    •	127.0.0.1:8000 pngwidget.de

Then enter this configurations to These I added to apache httpd-vhosts.conf :

    •	<VirtualHost *:80>
    •   ServerName pngwidget.de
    •   DocumentRoot "c:/PNWGWIDGET_PROJECT"
    •   <Directory "C:/PNWGWIDGET_PROJECT">
    •     DirectoryIndex app.php
    •     Options -Indexes
    •     AllowOverride All
    •     Allow from All
    •   </Directory>
    •   </VirtualHost>
