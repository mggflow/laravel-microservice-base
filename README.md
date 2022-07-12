# Laravel Microservice Base

## About

This project is base of microservice implements on Laravel.

## Usage

1. Create project
```
composer create-project mggflow/laravel-microservice-base msvc
```
2. Add files to Git
```
git add --all
```
3. Remove welcome page and set empty return
4. Install mggflow/auth-base or use your authentication way.
   1. ``composer require mggflow/auth-base``
   2. Add Auth Facades for auth-base: Additions, AuthControllers, RouteGroup, AuthDatabase config
   3. Tune auth database settings by env.
5. Update dependencies
```
composer update
```
6. Create your app logic with all advantages of Laravel. For example see app/Microservice/Controllers/MainController.php.
