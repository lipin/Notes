# How to setup nginx, php-fpm, mysql and wild card domain names using dnsmasq!

You need to start by installing the latest xcode version and command line tools.
 
We will use homebrew to install nginx, php-fpm, mysql and dnsmasq. Make sure you already have homebrew installed and ready to go. Lets go ahead and upate and upgrade our brew.
 
$~ brew update && brew upgrade
 
# PHP-FPM:
Lets start with intalling php-fpm first. We need to tap these two formulas for that:
 
$~ brew tap homebrew/dupes
$~ brew tap homebrew/php
 
Now we will install php-fpm without apache and with mysql. I use nginx for laravel too so I go with php version 5.5, you can use what ever version you prefer.
 
$~ brew install --without-apache --with-fpm --with-mysql php55
 
For using php command line binary we need to update our $PATH variable.
# If you use Bash    
$~ echo 'export PATH="$(brew --prefix homebrew/php/php55)/sbin:$PATH"' >> ~/.bash_profile && . ~/.bash_profile
# If you use ZSH
$~ echo 'export PATH="$(brew --prefix homebrew/php/php55)/sbin:$PATH"' >> ~/.zshrc && . ~/.zshrc
 
We are also going to setup auto start for php-fpm, so we dont have to start it everytime we login.
$~ mkdir -p ~/Library/LaunchAgents
$~ cp /usr/local/opt/php55/homebrew.mxcl.php55.plist ~/Library/LaunchAgents/
$~ launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.php55.plist
 
After this php-fpm should be running on your system. Use the following command to check it,
$~ lsof -Pni4 | grep LISTEN | grep php
 
# MySQL :
Time to install mysql. We will use brew again.
$~ brew install mysql
 
We do the same setup for mysql as we did for php-fpm to auto start it,
$~ ln -sfv /usr/local/opt/mysql/*.plist ~/Library/LaunchAgents
 
and lets go ahead and start our database server,
$~ launchctl load ~/Library/LaunchAgents/homebrew.mxcl.mysql.plist
 
For setting the username and password, in other words to secure our mysql installation run the following command,
$~ mysql_secure_installation
 
- For root password, since we dont have on set yet press enter.
- When prompted for changing the root password, say yes and select a root password
- I selected no for remote login 
- I selected yes for removing test database
- I selected yes for reloading privilege tables
 
Lets now test the connection. Type the following command,
$~ mysql -u root -p
 
Enter the root username and pass combination that you selected in the step before and you should see mysql console. Type \q to exit console.
 
Lets also install phpmyadmin to easily manage our databases, 
$~ brew install autoconf
# If you use Bash
$~ echo 'PHP_AUTOCONF="'$(which autoconf)'"' >> ~/.bash_profile && . ~/.bash_profile
# If you use ZSH
$~ echo 'PHP_AUTOCONF="'$(which autoconf)'"' >> ~/.zshrc && . ~/.zshrc
 
$~ brew install phpmyadmin
 
# Ngnix:
Lets proceed with installing ngnix now,
$~ brew install nginx
 
We also want to start nginx at login, so we will setup autostart for it too,
$~ sudo cp -v /usr/local/opt/nginx/*.plist /Library/LaunchDaemons/
$~ sudo chown root:wheel /Library/LaunchDaemons/homebrew.mxcl.nginx.plist
 
Launch nginx to test our connection 
$~ sudo launchctl load /Library/LaunchDaemons/homebrew.mxcl.nginx.plist
 
By default nginx uses port 8080 so goto the following url http://127.0.0.1:8080. Nginx should be up and running now.
Lets stop nginx now to do some more configuration,
 
$~ sudo launchctl unload /Library/LaunchDaemons/homebrew.mxcl.nginx.plist
 
We will create some folders to save nginx logs, ssl and sites-enables.
 
$~ mkdir -p /usr/local/etc/nginx/logs
$~ mkdir -p /usr/local/etc/nginx/sites-enabled
$~ mkdir -p /usr/local/etc/nginx/ssl
 
Next we will create the folder where our sites will live. You can use which ever folder you want, porvided you set the root parameter of ngnix configuration appropriately.
$~ mkdir -p ~/Sites
 
Now copy my nginx configuration from (https://github.com/TinyHook/nginx-configurations/blob/master/nginx.conf) and paste them in /usr/local/etc/nginx/nginx.conf
 
Do the same for the site-enabled folder copy drupal or larvel from (https://github.com/TinyHook/nginx-configurations/tree/master/sites-enabled)
You should have three files in /usr/local/etc/nginx/sites-enabled
- phpmyadmin
- drupal
- laravel
 
Now we need to setup SSL for both drupal and laravel. We will be generating RSA 4096 bit keys and we will be self signing the certificates
$~ mkdir -p /usr/local/etc/nginx/ssl
$~ openssl req -new -newkey rsa:4096 -days 365 -nodes -x509 -subj "/C=US/ST=State/L=Town/O=Office/CN=localhost" -keyout /usr/local/etc/nginx/ssl/localhost.key -out /usr/local/etc/nginx/ssl/localhost.crt
$~ openssl req -new -newkey rsa:4096 -days 365 -nodes -x509 -subj "/C=US/ST=State/L=Town/O=Office/CN=phpmyadmin" -keyout /usr/local/etc/nginx/ssl/phpmyadmin.key -out /usr/local/etc/nginx/ssl/phpmyadmin.crt
 
# Setting up some bash aliases
Because your probably need to restart the one or other service sooner or later, you probably want to set up some aliases.
You can copy bash alases from this file (https://github.com/TinyHook/nginx-configurations/blob/master/.bash_aliases).
 
# If you use Bash
$~ echo "source ~/.bash_aliases" >> ~/.bash_profile
# If you use ZSH
$~ echo "source ~/.bash_aliases" >> ~/.zshrc
 
After this restart terminal. Now you can stop, restart and start nginx, php-fpm and mysql like this,
 
$~ nginx.start
$~ nginx.stop
$~ nginx.restart
 
$~ php-fpm.start
$~ php-fpm.stop
$~ php-fpm.restart
 
$~ mysql.start
$~ mysql.stop
$~ mysql.restart
To quickly tail the latest error or access logs:
 
$~ nginx.logs.access
$~ nginx.logs.phpmyadmin.access
$~ nginx.logs.default-ssl.access
$~ nginx.logs.error
$~ nginx.logs.phpmyadmin.error
 
# Dnsmasq:
Lets now go ahead and set up dnsmasq for wild card domains. 
If you look at all the files in sites-enabled folder for ngnix. (/usr/local/etc/nginx/sites-enabled)
In Drupal case you will notice that on line 5, something like this:
root       /Users/masterbuilder/Sites/$sub.$domain/docroot;
 
You will need to change this line to wherever you would place all you Drupal files. Just make sure you leave the $sub.$domain/docroot part in.
The way I use wild card domains is by storing all Drupal files in the following manner
-> dirname.dev
			|--------> docroot
										|------> Drupal Core files go in there
 
Then my domian name would be (dru.dirname.dev). You can change this in the drupal or laravel ngnix configuration files.
 
Lets install dnsmasq,
$~ brew install dnsmasq
 
Also copy dnsmasq initial configuration to /usr/local/etc/ directory.
$~ cp /usr/local/opt/dnsmasq/dnsmasq.conf.example /usr/local/etc/dnsmasq.conf
 
Now edit your file and add this line.
address=/dev/127.0.0.1
 
This will direct all lookups for hostnames with a top level domain of dev to resolve to 127.0.0.1. If you want to use a different 
top level domain name, just replace dev with whatever you want and also update ngnix configurations.
 
Next make a link for the provided plists.
$~ ln -sfv /usr/local/opt/dnsmasq/*.plist /Library/LaunchDaemons
 
Now we need to tell OS X where to resolve our .dev addresses.
$~ sudo mkdir -p /etc/resolver
$~ sudo tee /etc/resolver/dev >/dev/null <<EOF
nameserver 127.0.0.1
EOF
 
Launch dnsmasq
$~ sudo launchctl load /Library/LaunchDaemons/homebrew.mxcl.dnsmasq.plist
 
Now to test our setup download drupal from http://drupal.org. Place it inside (~/Sites/drupal.dev/docroot/) directory.
Create a folder drupal.dev inside (~/Sites/drupal.dev/docroot/sites/) copy the default setting.php to this folder and setup a database.
You can setup a database using url http://phpmyadmin.dev:306 if you followed my phpmyadmin install instructions and used the phpmyadmin ngnix setup that I provided.
 
Restart ngnix, php-fpm and mysql using the following commands,
$~ mysql.restart
$~ php-fpm.restart
$~ ngnix.restart
 
Goto http://dru.drupal.dev/install.php and you should be able to install Drupal.