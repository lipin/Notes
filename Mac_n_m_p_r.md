Mac - nginx,mysql,php-fpm,redis
xcode
============
先从 AppStore 下载 xcode 并安装
然后再安装 xcode 的命令行:
xcode-select --install

brew
============
从官方网站上看相关说明：http://brew.sh
最下面是安装的语句，可能是：
ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
但各版本的路径可能不一样所以最好是安装时到官网查看一下当前的安装脚本。

redis
============
brew install redis
配置文件：/usr/local/etc/redis.conf
安装目录：/user/local/opt/redis/

开机自启动：
ln -sfv /usr/local/opt/redis/*.plist ~/Library/LaunchAgents
手动启动
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.redis.plist
或：
 
手动开启：redis-server /usr/local/etc/redis.conf

nginx
============
brew install nginx
安装目录: /usr/local/etc/nginx
web 目录：/usr/local/opt/nginx/html/

开机自启动：
ln -sfv /usr/local/opt/nginx/*.plist ~/Library/LaunchAgents

nginx 其它操作：
nginx --help
  -s signal     : 要执行的动作: stop, quit, reopen, reload
  -c filename   : 设置配置文件 (默认是: /usr/local/etc/nginx/nginx.conf)

手动启动 nginx 只需要在终端中输入：nginx 

mysql
============
brew install mysql
安装目录：/usr/local/opt/mysql/
数据目录: /usr/local/var/mysql/
配置文件：/usr/local/opt/mysql/my.cnf

开机自启动：
ln -sfv /usr/local/opt/mysql/*.plist ~/Library/LaunchAgents

手动启动或关闭：
mysql.server start
mysql.server stop

php
============
brew tap homebrew/dupes
brew tap josegonzalez/homebrew-php
brew install --without-apache --with-fpm --with-mysql php55
安装目录：/usr/local/opt/php55/
配置文件目录：/usr/local/etc/php/5.5

开机自启动：
ln -sfv /usr/local/opt/php55/*.plist ~/Library/LaunchAgents
手动启动：
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.php55.plist

让终端中可以执行PHP:
echo 'export PATH="$(brew --prefix josegonzalez/php/php55)/bin:$PATH"' >> ~/.bash_profile
注意：
由于 mac 自带的就有 php 和 php-fpm, 所以一定要弄清楚当前系统使用的是系统自带的还是自己安装的。
通过上面的命令，已经将终端的 php 设置成了自己安装的。可能通过命令去测试：
php -v
php-fpm -v
查看版本号。
系统默认的 php 配置文件在：/etc/php.ini
自己安装的在 /usr/local/etc/php/5.5/php.ini

关闭 php-fpm: grep php-fpm | xargs kill -9
启动：/usr/local/opt/php55/sbin/php-fpm
千万不要直接在命令行里：php-fpm, 因为这个是指向系统默认 php-fpm 的。

检测是否安装成功：
lsof -Pni4 | grep LISTEN | grep php

应该出现如下内容：
php-fpm   60500 sunyu    6u  IPv4 0x2bb44b1e52e1259d      0t0  TCP 127.0.0.1:9000 (LISTEN)
php-fpm   60501 sunyu    0u  IPv4 0x2bb44b1e52e1259d      0t0  TCP 127.0.0.1:9000 (LISTEN)
php-fpm   60502 sunyu    0u  IPv4 0x2bb44b1e52e1259d      0t0  TCP 127.0.0.1:9000 (LISTEN)
php-fpm   60503 sunyu    0u  IPv4 0x2bb44b1e52e1259d      0t0  TCP 127.0.0.1:9000 (LISTEN)

配置 nginx 中的 php
============
location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }

php 的 redis 扩展
============
brew install autoconf
 
cd /usr/local/opt/php55/include/php/ext/
 
wget http://pecl.php.net/get/redis-2.2.5.tgz
 
tar -zxf redis-2.2.5.tgz
 
cd redis-2.2.5
 
phpize
 
./configure --with-php-config=/usr/local/opt/php55/bin/php-config
 
make && make install
安装完成后，会生成redis.so, 路径是：
 
/usr/local/opt/php55/include/php/ext/redis-2.2.5/modules/redis.so
同时会往php的扩展目录复制一份，路径是：
 
/usr/local/Cellar/php55/5.5.18/lib/php/extensions/no-debug-non-zts-20121212/redis.so

在PHP配置文件中添加扩展：
#如果当前没有extension_dir的配置加上下面的：
extension_dir=/usr/local/Cellar/php55/5.5.18/lib/php/extensions/no-debug-non-zts-20121212/
 
extension = redis.so