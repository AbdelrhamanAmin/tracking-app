# Tracking App 
You can find Postman Collection here
## Postman collection
```https://www.getpostman.com/collections/e5eff842d73ebd4710d7```
## Steps to Run with Docker
- clone the repo 
    ```https://github.com/AbdelrhamanAmin/tracking-app.git ```
- Switch to the repo directory 
    ```cd tracking-app```
- Copy the example env file and make the required configuration changes in the .env file
    ```cp .env.exmple .env```
- run
    ```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    ```
    
- Start the app
    ```./vendor/bin/sail up -d```
    ```./vendor/bin/sail artisan key:generate```
- Run migrations 
    ```./vendor/bin/sail artisan migrate ```
