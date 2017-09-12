server {
    listen       80;
    server_name  tyq.maimaitree.com;
    root   /Users/melon/Documents/laravelwww/maimaitree/public;
    index  index.php index.html index.htm;

    access_log  /data/web_logs/$host.access.log main;

    location / {

        ssi on;
        ssi_silent_errors on;
        ssi_types text/shtml;

        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ ^/(config|src|test|project|vendor|lumen)/ {
        deny all;
        break;
    }

    location ~* (composer.json|composer.lock) {
        deny all;
    }

    location /static/ {
        charset UTF-8;
        access_log   off;
        expires      180m;
    }

    location /favicon.ico {
        access_log   off;
        expires      1d;
    }

    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root   /Users/melon/Documents/laravelwww/maimaitree/public;
    }

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    location ~ \.php$ {
        root           /data/www;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  /Users/melon/Documents/laravelwww/maimaitree/public$fastcgi_script_name;
        include        fastcgi_params;
    }

}