# Procés d'instal·lació WordPress

### Requisits del Sistema

- Servidor: Linux (Ubuntu 22.04)
- Servidor web: Apache
- Base de dades: MySQL
- Llenguatge de programació: PHP
- Memòria RAM: Mínim 512MB (1GB recomanat)
- Espai en disc: Mínim 1GB per a la instal·lació bàsica, més espai addicional per a contingut.

### Instal.lem les dependencies necessaries

```bash
sudo apt update
sudo apt install apache2 \
                 ghostscript \
                 libapache2-mod-php \
                 mysql-server \
                 php \
                 php-bcmath \
                 php-curl \
                 php-imagick \
                 php-intl \
                 php-json \
                 php-mbstring \
                 php-mysql \
                 php-xml \
                 php-zip
```  

### Creem el directori i descarreguem el Wordpress

```bash
sudo mkdir -p /srv/www
sudo chown www-data: /srv/www
curl https://wordpress.org/latest.tar.gz | sudo -u www-data tar zx -C /srv/www
```

### Configurem Apache

```apache
<VirtualHost *:80>
    DocumentRoot /srv/www/wordpress
    <Directory /srv/www/wordpress>
        Options FollowSymLinks
        AllowOverride Limit Options FileInfo
        DirectoryIndex index.php
        Require all granted
    </Directory>
    <Directory /srv/www/wordpress/wp-content>
        Options FollowSymLinks
        Require all granted
    </Directory>
</VirtualHost>
```

### Activem el site i desactivem el default-site

```bash
sudo a2ensite wordpress
sudo a2enmod rewrite
sudo a2dissite 000-default
```

### Configurem la base de dades

```sql
CREATE DATABASE wordpress;

CREATE USER wordpress@localhost IDENTIFIED BY '<your-password>';

GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP,ALTER
    -> ON wordpress.*
    -> TO wordpress@localhost;

FLUSH PRIVILEGES;
```

### Configuració del Wordpress per connectar a la base de dades

```bash
sudo -u www-data cp /srv/www/wordpress/wp-config-sample.php /srv/www/wordpress/wp-config.php

sudo -u www-data sed -i 's/database_name_here/wordpress/' /srv/www/wordpress/wp-config.php

sudo -u www-data sed -i 's/username_here/wordpress/' /srv/www/wordpress/wp-config.php

sudo -u www-data sed -i 's/password_here/<your-password>/' /srv/www/wordpress/wp-config.php
```

### Finalment obrim el wp-config.php i possum la informació de sota

```bash
sudo -u www-data nano /srv/www/wordpress/wp-config.php
```

```PHP
define('AUTH_KEY',         '+16cA>WcE0@B.I=lRu8W,A)-aX&pf[e@XwtA>*YX<ZY@;31w)xY^l<,00>v4T_EF');

define('SECURE_AUTH_KEY',  'UTmHB}-|Gz+e{P,~U=,]MWx2wQd|)qt$NC4jeC;(~5l=^u<Y9hZO,BQ9j@0Gsiu%');

define('LOGGED_IN_KEY',    '@L!-<IMf^)KY/KY;LOagp!n&^0#T`AKXX+<@||`F|~z)ZS|62_GQJn38}IDjd:Ft');

define('NONCE_KEY',        'l_QfOy saX[9rvh7,_@0Dw[l9(|Kp56:l+uSepXSp7>UBRu<8McBv=Dl?RKtM~0f');

define('AUTH_SALT',        'xkbS!i}IX(*bcXx4FMM8S[-4bi`^md1*>b[VZ`v!+sI;F=QY/U`q{,$g-R]~m^s0');

define('SECURE_AUTH_SALT', '4fY&)~b{z6Q#4mYF(j(aw|HwbM2G_sjE(>>1Yo.FcmT!K0<3uqk*Zw812APAxW=8');

define('LOGGED_IN_SALT',   '0zimP0j(_Y-<F6Jer=|_/llXY AJraniFi=)T T)3t}qw.ofzP6<FCH:-/+3^~oJ');

define('NONCE_SALT',       '=FVnf%~qWutJCd|+5j|K}.Z@Z?+zi 1N<j;ox?%7Y$t0|^$UBP)VX!AE3ov~-8c:');
```
