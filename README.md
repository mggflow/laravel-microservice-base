# Laravel Microservice Base

## About

This project is base of microservice implements on Laravel.

## Usage
Check all info about ports, volumes and other settings in:
`./docker-compose.yml`, `./.env.example`, `./config`. Also you can find useful bash scripts in `./scripts`

1. Create project in dir "msvc" via composer

```
composer create-project mggflow/laravel-microservice-base msvc
```

2. Add files to GIT

```
# git init
git add --all
```

3. Install composer dependencies

```
composer install
```

4. Use Docker for development without hardware dependencies
```
docker compose up -d
```

5. Create your app logic with all advantages of [Laravel](https://laravel.com). For example see
   app/HTTP/Controllers/GreetingsController.php and http://127.0.0.1:8009/api/greeting route


In the alternative case you can separately download "./scripts/install.sh" from GitHube repo and then
```
sudo sh ./install.sh -u1000 -g1000 -r"mggflow/laravel-microservice-base" -d"/mnt/path/to/project"
```
P.S.: with the same script you can install your project based on this
