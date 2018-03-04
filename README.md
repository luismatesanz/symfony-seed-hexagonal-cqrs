# Seed project
Symfony 4.0 Seed Application with architecture Hexagonal, CQRS and DDD.

Example Blog API with DDD and Aggregate Comments (Example).

Installation
------------ 

Execute in command line in path folder project:

  1. composer install
  2. configure .env your configuration data. 
  3. bin/console doctrine:create:database
  4. bin/console doctrine:schema:update --force --dump-sql

Enjoy the application.
  
Routes
------------

/api is a route for api application. <br />
/api/doc is a route for your api swagger documentation.


Test
------------
Execute in command line in path folder project:

    phpunit

TODO
------------

Pending test aggregate Post.  <br />
Pending test entity User.  <br />
