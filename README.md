ebookdownloader
===============

A Symfony project created on October 23, 2017, 2:17 pm.

symfony new ebookdownloader  
composer update  

http://localhost:8000/config.php  
php bin/console security:check  

composer install  

// cambio password root in mysql  
mysql -u root -p'toor'  
SHOW VARIABLES LIKE 'validate_password%';  
SET GLOBAL ...  
quit  
mysqladmin -u root -p'...' password 'toor'  

mysql -u root -p'toor'  
CREATE DATABASE ebookdownloader;  

git init  
git add .  
git commit -m '...'  
git remote add origin https://github.com/archistico/ebookdownloader.git  
git push origin master  

Aggiornare il locale rispetto al remoto  
git pull origin master  