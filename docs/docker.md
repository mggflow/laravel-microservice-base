# Some useful commands for docker deployment
### Build app by docker file
`sudo docker-compose build lv`
### Up app in background
`sudo docker-compose up -d`
### Show workdir contents
`docker-compose exec lv ls -al`
### Run composer install by root
`sudo docker-compose exec -u root lv composer install`
### Run command line under root in app
`sudo docker-compose exec -u root lv bash`
### Run laravel schedule
`docker-compose exec lv php artisan schedule:work`
### Down app
`sudo docker-compose down`
