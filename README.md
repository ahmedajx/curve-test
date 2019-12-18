# curve tech test

## Running using built in php server
 1. composer install
 2. php -S localhost:8000 -t public
 3. navigate to http://localhost:8000/api/exchange
 
## Running tests
    ./vendor/bin/phpunit
    
## Running using docker compose

 1. docker-compose up
 2. wait until the composer install job is completed.
 3. navigate to http://localhost/api/exchange


