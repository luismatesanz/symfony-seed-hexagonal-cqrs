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
  5. bin/console assets:install

Enjoy the application.
  
Routes
------------

/api is a route for api application. <br />
/api/doc is a route for your api swagger documentation.


Test
------------
Execute in command line in path folder project:

    phpunit

DOMAIN EVENTS
------------
To publish domain events you have to execute the DomainEventPublisher object statically. DomainEventPublisher::instance()->publish(DomainEvent). <br />
All domain events subscribers must implement the interface DomainEventSubscriber. <br />
All domain events subscribers have to be registered as a listener. <br />
All domain events are stored in CollectionInMemoryDomainEventSubscriber and then fire if the command execution is successful. <br />
You can implement the saving of domain events in the middleware (App\Kernel\Infrastructure\Domain\Event\DomainEventsMiddleware). <br />

HEXAGONAL
------------
Implements all adapters with interfaces in the infrastructure layer. <br />


CQRS
------------
All commands return modified entities except those that run asynchronously. <br />
Use the application layer in the controllers of the two communication buses. <br />


TODO
------------
Implement Event Domain asynchronous. <br />
Pending test aggregate Post.  <br />
Pending test entity User.  <br />
