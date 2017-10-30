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

php bin/console doctrine:schema:update --force  

// Sul server Ubuntu

sudo chown -R $USER $HOME/.composer

sudo apt-get update
sudo apt-get install php7.1-xml
sudo apt-get install php-mbstring

// su app_dev.php dare il permesso all'ip della macchina di lavoro

 HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)

 sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
 sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var

 sudo a2enmod php7.1
 sudo a2dismod php7.0
 sudo service apache2 restart
 
 // Directory condivisa

sudo apt install samba

mkdir -P 
sudo nano /etc/samba/smb.conf

[share]
comment = Ubuntu File Server Share
path = /home/dev/condivisa
browsable = yes
guest ok = yes
read only = no
create mask = 0755

sudo mkdir -p condivisa
sudo chown -R root:users condivisa
sudo chmod -R ug+rwx,o+rx-w condivisa

sudo useradd emilie -m -G users
passwd emilie
sudo usermod -aG users emilie

sudo smbpasswd -a emilie

[allusers]
 comment = All Users
 path = /srv/samba/allusers/
 valid users = @users
 force group = users
 create mask = 0660
 directory mask = 0771
 writable = yes

sudo service smbd restart
sudo service nmbd restart

// PROBLEMA STORAGE
sudo chown -R www-data:www-data var/cache
sudo chown -R www-data:www-data var/logs