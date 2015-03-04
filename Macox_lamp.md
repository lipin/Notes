用了一年的Mac OS X了，之前不熟悉这个系统，用的是系统自带的PHP 以及DMG包安装的MySQL，时间长了，慢慢觉得MacBook的速度跟不上了，虽然关机次数不多，但是每次开机，或者唤醒电脑的时候，系统明显有一定时间的卡顿。特别表现在开机的时候。完全可以去泡一个来一桶了。 因此干掉MD101上的光驱，换上256G的Sandisk SSD， 干掉原厂的2G * 2,换上8G * 2 。 速度应该是杠杠的了，至少可以再服役2年吧。
趁着这次加硬盘的机会，就准备彻底重做开发环境。现在对Mac也有了一定的了解，特地记录一下本次的开发环境安装详情，给自己一个备忘，希望也可以帮助到刚接触Mac环境的同学们。本开发环境，全部基于HomeBrew安装。
主要软件版本：PHP5.5.14，Nginx 1.6.0，MySQL5.6.19
OS X Mavericks

重新安装系统，在苹果商店下载好OS X Mavericks安装文件，然后准备一支16G的USB3.0 U盘。制作OS X Mavericks 全新安装启动U盘。
插上U盘，在终端执行：sudo /Applications/Install\ OS\ X\ Mavericks.app/Contents/Resources/createinstallmedia --volume /Volumes/untitled --applicationpath /Applications/Install\ OS\ X\ Mavericks.app --nointeraction
untitled 是你的u盘盘符，根据实际情况来。

Erasing Disk: 0%… 10%… 20%… 30%…100%…
>Copying installer files to disk…
Copy complete.
Making disk bootable…
Copying boot files…
>Copy complete.
>Done.
看到上面的信息说明启动盘制作成功。 安装起来so easy ：）

安装完成系统之后， 暂时还没有去迁移文件，由于本人喜好摄影，有大量RAW格式的原图在Aperture 的照片库中，尼康D800一张RAW文件有40M左右，到时候迁移照片库和照片流希望不要掉坑里了。 等开发环境搞定再说了，更新OS X系统到10.9.4 ，然后安装最新的Xcode， 以及在商店买过的软件。确定系统无问题了，进入下一步...
Brew

Brew 是 Mac 下面的包管理工具，通过 Github 托管适合 Mac 的编译配置以及 Patch，可以方便的安装开发工具。 Mac 自带ruby 所以安装起来很方便，同时它也会自动把git也给你装上。官方网站： http://brew.sh 。

安装完成之后，建议执行一下自检，brew doctor如果看到Your system is ready to brew. 那么你的brew已经可以开始使用了。
安装：

ruby -e "$(curl -fsSL https://raw.github.com/mxcl/homebrew/go/install)"
自检：

brew doctor
常用命令： （所有软件以PHP5.5为例子）

brew update                        #更新brew可安装包，建议每次执行一下
brew search php55                  #搜索php5.5
brew tap josegonzalez/php          #安装扩展<gihhub_user/repo>   
brew tap                           #查看安装的扩展列表
brew install php55                 #安装php5.5
brew remove  php55                 #卸载php5.5
brew upgrade php55                 #升级php5.5
brew options php55                 #查看php5.5安装选项
brew info    php55                 #查看php5.5相关信息
brew home    php55                 #访问php5.5官方网站
brew services list                 #查看系统通过 brew 安装的服务
brew services cleanup              #清除已卸载无用的启动配置文件
brew services restart php55        #重启php-fpm
注意：brew services 相关命令最好别经常用了，提示会被移除

➜  ~  brew services restart php55
Warning: brew services is unsupported and will be removed soon.
You should use launchctl instead.
Please feel free volunteer to support it in a tap.

Stopping `php55`... (might take a while)
==> Successfully stopped `php55` (label: homebrew.mxcl.php55)
==> Successfully started `php55` (label: homebrew.mxcl.php55)
Oh My Zsh

ohmyzsh & iTerm2两个神器，在Mac os x下是一定要装的. 两组配合起来使用，加上插件。简直是神一样的存在。 秒杀梅西，内马尔啊：） Oh 猛戳到官网
安装 oh my zsh

curl -L http://install.ohmyz.sh | sh
设置默认shell

查看系统支持的shell列表，Mac 10.9.4 自带了 zsh 5.0.2，Linux上得安装。
cat /etc/shells
# List of acceptable shells for chpass(1).
# Ftpd will not allow users to connect who are not using
# one of these shells.

/bin/bash
/bin/csh
/bin/ksh
/bin/sh
/bin/tcsh
/bin/zsh
zsh --version
zsh 5.0.2 (x86_64-apple-darwin13.0)
chsh -s /bin/zsh
虽然Mac自带了zsh，如果你想要最新版的zsh，那么你用 brew install zsh安装一个最新的吧。/usr/local/bin/zsh --version zsh 5.0.5 (x86_64-apple-darwin13.3.0) 区别也不会很大， 默认的版本已经很新了。
homebrew-cask

安装cask：

brew tap phinze/homebrew-cask && brew install brew-cask 
cask常用命令：

brew cask search        #列出所有可以被安装的软件
brew cask search php    #查找所有和php相关的应用
brew cask list          #列出所有通过cask安装的软件
brew cask info phpstorm #查看 phpstorm 的信息
brew cask uninstall qq  #卸载 QQ
这里谈谈cask对比Mac App Store的优势：
对常用软件支持更全面（特别是开发者），cask里面会给你一些惊喜；
软件更新速度快，一般都是最新版本 Store上很久很久才会更新版本；
命令安装感觉比打开Store方便，另外Store在国内的速度也是XXOO。
iTerm2

安装iTerm2：

brew cask install iterm2
上面提过的神器组合，更多使用方法请参考iTerm2官方文档， 这里就不详细说明了。
安装开发常用的包&软件

安装开发包

brew install wget watch tmux cmake openssl imagemagick graphicsmagick gearman geoip readline autoconf multitail source-highlight autojump zsh-completions sshfs 
升级一下系统自带的vim
brew install ctags macvim --env-std --override-system-vim

安装常用软件

brew cask install alfred appcleaner firefox google-chrome phpstorm sublime-text sequel-pro sketch mplayerx thunder qq
Alfred 是个很不错的东西，推荐必须安装。它默认搜索目录不包含brew cask安装的软件，因此手动将/opt/homebrew-cask添加到Alfred的搜索目录
MySQL PHP Nginx Redis Memcache

前面做了这么多的准备工作，其实 zsh iTerm2 brew 等等这些由于篇幅以及能力有限，一时半会也讲不完，更多选择，更多欢乐，就在Google search，现在才入正题。come on ：）
安装MySQL

brew install mysql
MySQL开机启动：

ln -sfv /usr/local/opt/mysql/*.plist ~/Library/LaunchAgents
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.mysql.plist
安装完成之后开启MySQL安全机制：

/usr/local/opt/mysql/bin/mysql_secure_installation
根据终端提示，输入root密码，然后依次确认一些安全选项。具体信息可以参考外国友人的这篇文章

#查看一下MySQL运行情况
➜  ~  ps aux | grep mysql
calvin           1695   0.0  0.5  2719864  90908   ??  S     1:38上午   0:00.31 /usr/local/Cellar/mysql/5.6.19/bin/mysqld --basedir=/usr/local/Cellar/mysql/5.6.19 --datadir=/usr/local/var/mysql --plugin-dir=/usr/local/Cellar/mysql/5.6.19/lib/plugin --bind-address=127.0.0.1 --log-error=/usr/local/var/mysql/CalvinsMacBook-Pro.local.err --pid-file=/usr/local/var/mysql/CalvinsMacBook-Pro.local.pid --socket=/tmp/mysql.sock --port=3306
calvin           1323   0.0  0.0  2444628   1020   ??  S     1:38上午   0:00.04 /bin/sh /usr/local/opt/mysql/bin/mysqld_safe --bind-address=127.0.0.1 --datadir=/usr/local/var/mysql

#测试连接MySQL
mysql -uroot -p
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 23
Server version: 5.6.19-log Homebrew

Copyright (c) 2000, 2014, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql>
安装phpmyadmin

brew install phpmyadmin
安装PHP

添加brew的PHP扩展库：

brew update
brew tap homebrew/dupes
brew tap josegonzalez/homebrew-php
可以使用brew options php55命令来查看安装php5.5的选项，这里我用下面的选项安装：

brew install php55 --with-fpm --with-gmp --with-imap --with-tidy --with-debug --with-mysql --with-libmysql
PHP编译过程中如果遇到configure: error: Cannot find OpenSSL's <evp.h>错误，执行xcode-select --install 重新安装一下Xcode Command Line Tools 在GitHub HomeBrew上有关于这个讨论:
For future reference of anybody looking for Command Line Tools with Xcode 5, open up a Terminal window and type xcode-select --install. A window will appear informing you command line tools are required. Click Install and you should be good to go
等待PHP编译完成，开始安装PHP常用扩展，扩展安装过程中brew会自动安装依赖包，例如php55-pdo-pgsql 会自动装上postgresql,这里我安装以下PHP扩展：

brew install php55-apcu\
 php55-gearman\
 php55-geoip\
 php55-gmagick\
 php55-imagick\
 php55-intl\
 php55-mcrypt\
 php55-memcache\
 php55-memcached\
 php55-mongo\
 php55-opcache\
 php55-pdo-pgsql\
 php55-phalcon\
 php55-redis\
 php55-sphinx\
 php55-swoole\
 php55-uuid\
 php55-xdebug;
扩展里面提一下php55-phalcon 和 php55-swoole. 一个是C语言写的PHP框架，安装来个人摸索熟悉一下，还没有真正的使用过，大致看了一下文档，感觉非常吊炸天。目前公司的项目是基于Yii2的，也看看这个框架。 另外一个swoole是国产的PHP高性能网络通信框架，貌似不错，可能在项目中会考虑用到它。
由于Mac自带了php和php-fpm，因此需要添加系统环境变量PATH来替代自带PHP版本。

echo 'export PATH="$(brew --prefix php55)/bin:$PATH"' >> ~/.bash_profile  #for php
echo 'export PATH="$(brew --prefix php55)/sbin:$PATH"' >> ~/.bash_profile  #for php-fpm
echo 'export PATH="/usr/local/bin:/usr/local/sbib:$PATH"' >> ~/.bash_profile #for other brew install soft
source ~/.bash_profile
测试一下效果：

#brew安装的php 他在/usr/local/opt/php55/bin/php
php -v    
PHP 5.5.14 (cli) (built: Jul 16 2014 15:43:06) (DEBUG)
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies
    with Zend OPcache v7.0.3, Copyright (c) 1999-2014, by Zend Technologies
    with Xdebug v2.2.5, Copyright (c) 2002-2014, by Derick Rethans 

#Mac自带的PHP
/usr/bin/php -v   
PHP 5.4.24 (cli) (built: Jan 19 2014 21:32:15) 
Copyright (c) 1997-2013 The PHP Group
Zend Engine v2.4.0, Copyright (c) 1998-2013 Zend Technologies

#brew安装的php-fpm 他在/usr/local/opt/php55/sbin/php-fpm
php-fpm -v
PHP 5.5.14 (fpm-fcgi) (built: Jul 16 2014 15:43:12) (DEBUG)
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies
    with Zend OPcache v7.0.3, Copyright (c) 1999-2014, by Zend Technologies
    with Xdebug v2.2.5, Copyright (c) 2002-2014, by Derick Rethans

#Mac自带的php-fpm
/usr/sbin/php-fpm -v
PHP 5.4.24 (fpm-fcgi) (built: Jan 19 2014 21:32:57)
Copyright (c) 1997-2013 The PHP Group
Zend Engine v2.4.0, Copyright (c) 1998-2013 Zend Technologies
修改php-fpm配置文件，vim /usr/local/etc/php/5.5/php-fpm.conf，找到pid相关大概在25行，去掉注释 pid = run/php-fpm.pid, 那么php-fpm的pid文件就会自动产生在/usr/local/var/run/php-fpm.pid，下面要安装的Nginx pid文件也放在这里。

#测试php-fpm配置
php-fpm -t
php-fpm -c /usr/local/etc/php/5.5/php.ini -y /usr/local/etc/php/5.5/php-fpm.conf -t

#启动php-fpm
php-fpm -D
php-fpm -c /usr/local/etc/php/5.5/php.ini -y /usr/local/etc/php/5.5/php-fpm.conf -D

#关闭php-fpm
kill -INT `cat /usr/local/var/run/php-fpm.pid`

#重启php-fpm
kill -USR2 `cat /usr/local/var/run/php-fpm.pid`

#也可以用上文提到的brew命令来重启php-fpm，不过他官方不推荐用这个命令了
brew services restart php55

#还可以用这个命令来启动php-fpm
launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.php55.plist

启动php-fpm之后，确保它正常运行监听9000端口：

lsof -Pni4 | grep LISTEN | grep php
php-fpm   30907 calvin    9u  IPv4 0xf11f9e8e8033a2a7      0t0  TCP 127.0.0.1:9000 (LISTEN)
php-fpm   30917 calvin    0u  IPv4 0xf11f9e8e8033a2a7      0t0  TCP 127.0.0.1:9000 (LISTEN)
php-fpm   30918 calvin    0u  IPv4 0xf11f9e8e8033a2a7      0t0  TCP 127.0.0.1:9000 (LISTEN)
php-fpm   30919 calvin    0u  IPv4 0xf11f9e8e8033a2a7      0t0  TCP 127.0.0.1:9000 (LISTEN)
#正常情况，会看到上面这些进程
PHP-FPM开机启动：

ln -sfv /usr/local/opt/php55/*.plist ~/Library/LaunchAgents
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.php55.plist
安装php composer

brew install composer
#检查一下情况
composer --version
Composer version 1.0.0-alpha8 2014-01-06 18:39:59
redis memcached这些软件brew 已经自动依赖安装上，如果想开机自动启动，或者查看使用说明 brew info redis即可。另外，composer的中文文档：猛戳这里
安装Nginx

brew install nginx --with-http_geoip_module
Nginx启动关闭命令：

#测试配置是否有语法错误
nginx -t

#打开 nginx
sudo nginx

#重新加载配置|重启|停止|退出 nginx
nginx -s reload|reopen|stop|quit

#也可以使用Mac的launchctl来启动|停止
launchctl unload ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist
launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist

Nginx开机启动

ln -sfv /usr/local/opt/nginx/*.plist ~/Library/LaunchAgents
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist
Nginx监听80端口需要root权限执行，因此：

sudo chown root:wheel /usr/local/Cellar/nginx/1.6.0_1/bin/nginx
sudo chmod u+s /usr/local/Cellar/nginx/1.6.0_1/bin/nginx
配置nginx.conf
创建需要用到的目录：

mkdir -p /usr/local/var/logs/nginx
mkdir -p /usr/local/etc/nginx/sites-available
mkdir -p /usr/local/etc/nginx/sites-enabled
mkdir -p /usr/local/etc/nginx/conf.d
mkdir -p /usr/local/etc/nginx/ssl
sudo mkdir -p /var/www
sudo chown :staff /var/www
sudo chmod 775 /var/www
vim /usr/local/etc/nginx/nginx.conf 输入以下内容：

worker_processes  1;

error_log   /usr/local/var/logs/nginx/error.log debug;


pid        /usr/local/var/run/nginx.pid;


events {
    worker_connections  256;
}


http {
    include       mime.types;
    default_type  application/octet-stream;

    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';

    access_log  /usr/local/var/logs/access.log  main;

    sendfile        on;
    keepalive_timeout  65;
    port_in_redirect off;

    include /usr/local/etc/nginx/sites-enabled/*;
}

设置nginx php-fpm配置文件

vim /usr/local/etc/nginx/conf.d/php-fpm
#proxy the php scripts to php-fpm
location ~ \.php$ {
    try_files                   $uri = 404;
    fastcgi_pass                127.0.0.1:9000;
    fastcgi_index               index.php;
    fastcgi_intercept_errors    on;
    include /usr/local/etc/nginx/fastcgi.conf;
}
nginx虚拟主机准备工作

#创建 info.php index.html 404.html 403.html文件到 /var/www 下面
vi /var/www/info.php
vi /var/www/index.html
vi /var/www/403.html
vi /var/www/404.html
创建默认虚拟主机default
vim /usr/local/etc/nginx/sites-available/default输入：

server {
    listen       80;
    server_name  localhost;
    root         /var/www/;

    access_log  /usr/local/var/logs/nginx/default.access.log  main;

    location / {
        index  index.html index.htm index.php;
        autoindex   on;
        include     /usr/local/etc/nginx/conf.d/php-fpm;
    }

    location = /info {
        allow   127.0.0.1;
        deny    all;
        rewrite (.*) /.info.php;
    }

    error_page  404     /404.html;
    error_page  403     /403.html;
}
创建ssl默认虚拟主机default-ssl
vim /usr/local/etc/nginx/sites-available/default-ssl输入：

server {
    listen       443;
    server_name  localhost;
    root       /var/www/;

    access_log  /usr/local/var/logs/nginx/default-ssl.access.log  main;

    ssl                  on;
    ssl_certificate      ssl/localhost.crt;
    ssl_certificate_key  ssl/localhost.key;

    ssl_session_timeout  5m;

    ssl_protocols  SSLv2 SSLv3 TLSv1;
    ssl_ciphers  HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers   on;

    location / {
        include   /usr/local/etc/nginx/conf.d/php-fpm;
    }

    location = /info {
        allow   127.0.0.1;
        deny    all;
        rewrite (.*) /.info.php;
    }

    error_page  404     /404.html;
    error_page  403     /403.html;
}
创建phpmyadmin虚拟主机

vim /usr/local/etc/nginx/sites-available/phpmyadmin #输入以下配置
server {
    listen       306;
    server_name  localhost;
    root    /usr/local/share/phpmyadmin;

    error_log   /usr/local/var/logs/nginx/phpmyadmin.error.log;
    access_log  /usr/local/var/logs/nginx/phpmyadmin.access.log main;

    ssl                  on;
    ssl_certificate      ssl/phpmyadmin.crt;
    ssl_certificate_key  ssl/phpmyadmin.key;

    ssl_session_timeout  5m;

    ssl_protocols  SSLv2 SSLv3 TLSv1;
    ssl_ciphers  HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers   on;

    location / {
        index  index.html index.htm index.php;
        include   /usr/local/etc/nginx/conf.d/php-fpm;
    }
}
设置SSL

mkdir -p /usr/local/etc/nginx/ssl
openssl req -new -newkey rsa:4096 -days 365 -nodes -x509 -subj "/C=US/ST=State/L=Town/O=Office/CN=localhost" -keyout /usr/local/etc/nginx/ssl/localhost.key -out /usr/local/etc/nginx/ssl/localhost.crt
openssl req -new -newkey rsa:4096 -days 365 -nodes -x509 -subj "/C=US/ST=State/L=Town/O=Office/CN=phpmyadmin" -keyout /usr/local/etc/nginx/ssl/phpmyadmin.key -out /usr/local/etc/nginx/ssl/phpmyadmin.crt
创建虚拟主机软连接，开启虚拟主机

ln -sfv /usr/local/etc/nginx/sites-available/default /usr/local/etc/nginx/sites-enabled/default
ln -sfv /usr/local/etc/nginx/sites-available/default-ssl /usr/local/etc/nginx/sites-enabled/default-ssl
ln -sfv /usr/local/etc/nginx/sites-available/phpmyadmin /usr/local/etc/nginx/sites-enabled/phpmyadmin
启动|停止Nginx

launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist
launchctl unload -w ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist
接下来你可以通过下面这些连接访问：


http://localhost/ -> index.html
http://localhost/info -> info.php via phpinfo();
http://localhost/404 -> 404.html
https://localhost/ -> index.html(SSL)
https://localhost/info -> info.php via phpinfo();(SSL)
https://localhost/404 -> 404.html(SSL)
https://localhost:306 -> phpmyadmin(SSL)
设置快捷服务控制命令

为了后面管理方便，将命令 alias 下，vim ~/.bash_aliases 输入一下内容：

alias nginx.start='launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist'
alias nginx.stop='launchctl unload -w ~/Library/LaunchAgents/homebrew.mxcl.nginx.plist'
alias nginx.restart='nginx.stop && nginx.start'
alias php-fpm.start="launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.php55.plist"
alias php-fpm.stop="launchctl unload -w ~/Library/LaunchAgents/homebrew.mxcl.php55.plist"
alias php-fpm.restart='php-fpm.stop && php-fpm.start'
alias mysql.start="launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.mysql.plist"
alias mysql.stop="launchctl unload -w ~/Library/LaunchAgents/homebrew.mxcl.mysql.plist"
alias mysql.restart='mysql.stop && mysql.start'
alias redis.start="launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.redis.plist"
alias redis.stop="launchctl unload -w ~/Library/LaunchAgents/homebrew.mxcl.redis.plist"
alias redis.restart='redis.stop && redis.start'
alias memcached.start="launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.memcached.plist"
alias memcached.stop="launchctl unload -w ~/Library/LaunchAgents/homebrew.mxcl.memcached.plist"
alias memcached.restart='memcached.stop && memcached.start'
#让快捷命令生效
echo "[[ -f ~/.bash_aliases ]] && . ~/.bash_aliases" >> ~/.bash_profile     
source ~/.bash_profile
#创建站点目录到主目录，方便快捷访问
ln -sfv /var/www ~/htdocs