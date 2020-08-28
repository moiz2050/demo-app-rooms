# Demo Get rooms app

#### Introduction
A small get rooms demo app where advertisement data (from hotels) is coming from 2 different sources and this app is combining it in a 
unified structure considering the duplication and less price as well. The code is completely extendible to add as many data sources as you want.

#### Installation / Credentials
##### Pre-requisite:
- Docker
##### Steps:
- From project root run ``./bin/install.sh`` (Be Patient :))
- API end point ``GET http://localhost:9090/api/rooms``

#### Environment

- Docker based environment 2 containers ``nginx``, ``php``

#### Tech Stack / Libraries

- Nginx
- Laravel Php Framework
- Docker

#### Approaches and standards
- The code is according to PSR-12 standard.
- Single responsibility principle has been followed.
- Adapter pattern has been used to integrate multiple services flawlessly.
- Transformers to transform different type of data into a unified structure.

#### Test
- By default, when you install it runs all the tests automatically.
- If you want to run manually below is the command.
- ``docker-compose exec php ./vendor/bin/phpunit ./tests/``