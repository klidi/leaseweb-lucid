# Leaseweb lucid

First of all thank you very much for taking time to review this!

In order to implement this i thought to do something different from the boring out of the box framework layered architecture.
There are 2 interesting architectures that emerged in the last years in the world of laravel but not only , one is lucid and the other is porto , porto also 
has a great scaffolding tool on top of laravel for building APi-centric application. So i decided to give it a try with lucid architecture.

Lucid architecture [documentation](https://lucid-architecture.gitbook.io/docs/)

## Project structure

Appart from the normal laravel structure you will find: 

app :
- Data 
- Domains 
- Features 
- Operations, 
- Foundation

## Application workflow

Workflow its very simple, controller always interacts with a feature, features eather runs an operation or multiple, which are a job wrappers, or runs jobs.
Jobs dont run other jobs.

I have implemented a very basic oauth2 with laravel passport enabling user registration and authentication

## Domain Modeling decisions

Server and Brand are normal eloquent models Price, Currency, RamModule, RamModuleType are Value Objects.

Normally you would ask why RamModule is modeled as a value object . Given the business invariants it does not make sense 
to me that RamModule has an identity. To me its an not a mutable object just like a ram module in real life. U can not change
its size or type.  Even in a business case where we would have an inventory of ram modules i still would not consider it as something with an identity.

Apart from this i have tried to encapsulate all invariants inside the appropriate object leaving almost nothing in the hands of the application layer.
I am a big fan of behavioral, unbreakable and very granular(in relation to invariants) models instead of anemic models that have only getters and setters

## How to run

Project runs on php 7.4 (sorry :P )

- composer install
- artisan migrate
- artisan seed (some basic data to populate db)
- php artisan serve to run the internal php web server

I hope i did not forget something.
