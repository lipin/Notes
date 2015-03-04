server {
    listen          8088;
    server_name     localhost;
    index           index.php index.html;
    root            /Users/srui/Documents/site/public;
    charset         utf-8;

    client_max_body_size 10m;

    location = /favicon.ico {
        log_not_found off;
        access_log off;
    }

#    location = /robots.txt {
#        allow all;
#        log_not_found off;
#        access_log off;
#    }

    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|swf)$ {
        expires 48h;
    }

    location ~ \.php {
        fastcgi_split_path_info     ^(.+\.php)(/.*)$;
        fastcgi_param               PATH_INFO                               $fastcgi_script_name;
        include                     /usr/local/etc/nginx/fastcgi.conf;
        fastcgi_pass                127.0.0.1:9000;
        fastcgi_index               index.php;
        #expires                     off;
    }

    location / {
        if (!-e $request_filename){
            rewrite ^/(.*) /index.php last;
        }
    }

}