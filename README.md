#How to run

* clone repository
* run `docker-compose up` in the repo directory
* run `docker exec -it mytask_test_php_1 /bin/bash -c "cd app ; composer install"`
* run `docker exec -it mytask_test_php_1 /bin/bash -c "cd app ; php bin/console doctrine:migrations:migrate"`
