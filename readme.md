# Projeto de painel para sites personalizados✨

### Instalação do docker e laravel 🧑🏾‍🔧
Entre na pasta do laravel e copie o .env.exemple para .env
e execute:

```sh
$ docker-compose up -d --build
``` 

### Criando o banco de dados 📒🎲
```
$ docker-compose exec adminpanelv3api artisan migrate:fresh --seed 
```
#### * Talvez seja necessário rodar a seeder separada, então pode rodar:
```sh
$ docker-compose exec adminpanelv3api php -c php.ini artisan db:seed --class=DatabaseSeeder
```
####  * Vai rodar porta:80 🚪

### Acessos do pgadmin 🔐🤫
```md
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=pgadmin

PGADMIN_DEFAULT_EMAIL=local@adminpanelv3.com
PGADMIN_DEFAULT_PASSWORD=pgadmin
```

DOCKER DICAS 🤯💡

```sh
# remover todas as imagens
$ docker image rm $(docker images)
# remover todos os volumes
$ docker volume prune
# listar os volumes
$ docker volume ls 
```
