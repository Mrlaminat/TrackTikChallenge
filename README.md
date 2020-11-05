TrackTic Challenge application
=======
This is the console interface project which provides an interactive console.
Base on the Symfony (https://symfony.com/) 4.4

Main features
============
This project was developed to demonstrate symfony 4 features for the simple REST API 
and can be extended in multiple ways. For example: adding custom scenarios
(different quantities, types, and extras, additional electronic items, adding database/cache storage).
- Set electronic devices properties as price and extras.
- Proceed through a prepared scenario: 
    - return sorted items
    - return the total price
    - return price by type.

Requirements
============
In order to install this project make sure you meet the following requirements.

* PHP >= 7.4 (`php -v`)
* Composer

Or use pre-installed docker image with all necessary components. 

Install
=======

Download project:

    git clone git@github.com:Mrlaminat/TrackTikChallenge.git


## Container Usage

Run `docker-compose up -d --build`. Open up your browser of choice to [http://tracktik.challenge.localhost:8088/](http://tracktik.challenge.localhost:8088/) and you should see your Laravel app running as intended. 

Containers created, and their ports (if used) are as follows:

- **nginx** - `:8088`
- **php** - `:9001`

Install the PHP dependencies by running the following command in the projects
root folder:

    composer install
    
For the Docker setup

Install libraries

    docker-compose run --rm app composer install

Clear cache

    docker-compose run --rm app php bin/console cache:clear


Enable xDebug

    docker exec -u root -it tracktik-challenge-app /./usr/local/bin/php-xdebug


Disable xDebug

    docker exec -u root -it tracktik-challenge-app /./usr/local/bin/php-xdebug


Using
=========================

API for the base scenario:

    POST http://tracktik.challenge.localhost:8088/api/base-scenario

Simple prepared payload

    {
        "electronic_list": [
            {
                "item_type": "console",
                "item_price": 399.99,
                "item_extras": [
                    {
                        "item_type": "controller",
                        "item_wired": true,
                        "item_price": 49.99
                    },
                    {
                        "item_type": "controller",
                        "item_wired": true,
                        "item_price": 49.99
                    },
                    {
                        "item_type": "controller",
                        "item_wired": false,
                        "item_price": 60
                    },
                    {
                        "item_type": "controller",
                        "item_wired": false,
                        "item_price": 60
                    }
                ]
            },
            {
                "item_type": "television",
                "item_price": 699.99,
                "item_extras": [
                    {
                        "item_type": "controller",
                        "item_wired": true,
                        "item_price": 70
                    },
                    {
                        "item_type": "controller",
                        "item_wired": true,
                        "item_price": 0
                    }
                ]
            },
            {
                "item_type": "television",
                "item_price": 550,
                "item_extras": [
                    {
                        "item_type": "controller",
                        "item_wired": true,
                        "item_price": 60
                    }
                ]
            },
            {
                "item_type": "microwave",
                "item_price": 300
            }
        ],
        "requirements": [
            {
                "item_type": "console",
                "max_extras" : 4
            },
            {
                "item_type": "television",
                "max_extras" : null
            },
            {
                "item_type": "microwave",
                "max_extras" : 0
            },
            {
                "item_type": "controller",
                "max_extras" : 0
            }
        ]
    }
    
Have fun!

