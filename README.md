#How to run

* run `git clone git@github.com:nacholibre/docker-test-task.git; cd docker-test-task`
* run `docker-compose up` in the repo directory
* run `docker exec -it docker-test-task_php_1 /bin/bash -c "cd app ; composer install"`
* run `docker exec -it docker-test-task_php_1 /bin/bash -c "cd app ; php bin/console doctrine:migrations:migrate"` and type `y`

* open web browser and navigate to http://localhost:8887
