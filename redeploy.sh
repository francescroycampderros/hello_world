#!/bin/sh

php /var/www/francescroy.com/vendor/bin/drush.php un hello_world
php /var/www/francescroy.com/vendor/bin/drush.php en hello_world
php /var/www/francescroy.com/vendor/bin/drush.php cache-rebuild
