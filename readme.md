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

Workflow its very simple, controller always interacts with a feature, feature eather runs an operation or multiple, which are job wrappers, or runs jobs.
Jobs don't run other jobs. 

I have implemented a very basic oauth2 with laravel passport enabling user registration and authentication

## Domain Modeling decisions

Server and Brand are normal eloquent models Price, Currency, RamModule, RamModuleType are Value Objects.

Normally you would ask why RamModule is modeled as a value object . Given the business invariants it does not make sense 
to me that RamModule has an identity. To me its an not a mutable object just like a ram module in real life. U can not change
its size or type.  Even in a business case where we would have an inventory of ram modules i still would not consider it as something with an identity.

Consider the Server the agregate root , and this agregate is composed by a model/Entity and many Value Objects
Brand is not part of the Server agregate as it has its own lifecycle

Price and RamModules are persisted as json in the db , and they are casted to ValueObjects or collection and the other
way around with a Casting class, find them inside app/Foundation/Casts

Apart from this i have tried to encapsulate all invariants inside the appropriate object leaving almost nothing in the hands of the application layer.
I am a big fan of behavioral, unbreakable and very granular(in relation to invariants) models instead of anemic models that have only getters and setters

## Testing

Testing follows the same structure as the app, I have added some unit tests for various jobs , but no feature tests. In total there is like 45 tests.
It takes an awful amount of time to add tests coverage to 100% and it did not make sense to me to keep doing that due to not having a a lot of free time lately.

## How to run

Project runs on php 7.4 (sorry :P )

- composer install
- artisan migrate
- artisan seed (some basic data to populate db)
- php artisan serve to run the internal php web server

I hope i did not forget something. If u have any trouble to setup let me know and I will try to host it with heroku.

# Routes


http://18.185.94.188/api/register | POST
```
{
    "name": "user1",
    "email": "user1@gmail.com",
    "password": "secret123",
    "password_confirmation": "secret123"
 }
 ```
 
 http://18.185.94.188/api/login | POST
 ```
 {
     "email": "user1@gmail.com",
     "password": "secret123",
  }
  ```
  http://18.185.94.188/api/users/{userId}/servers | GET
  
  http://18.185.94.188/api/users/{userId}/servers | POST
  
  ```
  {
      "asset_id": 2347478975,
      "name": "Server test 1",
      "brand_id": 2,
      "price": {
          "amount": 122,
          "currency": "USD"
      },
      "ram_modules": [
          {
              "type": "DDR4",
              "size": "1024"
          }
      ]
  }
  ```
  http://18.185.94.188/api/users/{userId}/servers/{serverId} | GET
  
  http://18.185.94.188/api/users/{userId}/servers/{serverId} | DELETE
  
 
 
 
 
