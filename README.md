#How to run

* clone repository
* run `docker-compose up` in the repo directory
* run `docker exec -it folder_php_1 /bin/bash -c "cd app ; composer install"`
* run `docker exec -it folder_php_1 /bin/bash -c "cd app ; php bin/console doctrine:migrations:migrate"` and type `y`

* open web browser and navigate to http://localhost:8887
