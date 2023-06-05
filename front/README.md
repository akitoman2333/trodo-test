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

    docker-compose exec vite_docker yarn

    docker-compose exec vite_docker yarn dev

Open your project’s .env file and set the following

    VITE_API_URL=http://localhost:89/api/v1

You can now access the server at http://localhost:8000
