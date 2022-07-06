# Deploiement

Conf nginx pour l'api :
````nginx
server {
    server_name hangover.timotheedurand.fr;

    location / {
    proxy_pass http://localhost:8080/;
    }

    location /admin {
        proxy_pass http://localhost:8081/;
    }
}
````

Conf nginx pour le hub mercure 
````nginx
server {

     server_name hangover-hub.timotheedurand.fr;

    location / {
        proxy_pass http://localhost:1234/ ;
        proxy_read_timeout 24h;
        proxy_http_version 1.1;
        proxy_set_header Connection "";

        ## Be sure to set USE_FORWARDED_HEADERS=1 to allow the hub to use those headers ##
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Forwarded-Proto $scheme;
    }

}
````
