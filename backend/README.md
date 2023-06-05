# Getting started

## Installation

Clone the repository

    git clone {{link}}

Switch to the repo folder

    cd {{folder}}

Run your containers

    docker-compose build
    
    docker-compose up -d
    
Switch to the repo folder

    cd www
    
Install all the dependencies using composer

    docker-compose exec app composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Open your project’s .env file and set the following

    DB_CONNECTION=mysql
    DB_DATABASE=apptest
    DB_USERNAME=root
    DB_PASSWORD=root

Command update:history-currencies

    docker-compose exec app php artisan update:history-currencies

Generate a new application key

    docker-compose exec app php artisan key:generate

Generate a new JWT authentication secret key

    docker-compose exec app php artisan jwt:generate  // (Optional if required)

    docker-compose exec app php artisan jwt:secret

    docker-compose exec app php artisan l5-swagger:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    docker-compose exec app php artisan migrate

Run the test

    docker-compose exec app php artisan test
   
Run the seed
    
    docker-compose exec app php artisan db:seed

You can now access the server at http://localhost:89

**API auth**

Open the link    

    http://localhost:89/api/documentation

Select Authentication, /auth/user.

    login: admin@gmail.com
    password: password



