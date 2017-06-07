server {
    listen       80;
    server_name  tyq.maimaitree.com;

    #access_log  /var/log/nginx/log/host.access.log  main;

    location / {
        root   /Users/melon/Documents/laravelwww/maimaitree/public;
        index  index.php index.html index.htm;
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


server {
    listen       80;
    server_name  admin.tyq.maimaitree.com;

    #access_log  /var/log/nginx/log/host.access.log  main;

    location / {
        root   /Users/melon/Documents/laravelwww/maimaitree/public;
        index  index.php index.html index.htm;
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