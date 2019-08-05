# music-collection

## Dependencies

* symfony 4.4
* php
* mysql server


## Install

git clone https://github.com/jnewmar/music-collection.git

cd music-collection/music-collection/

Edit database settings in file .env

vi ./.env

composer install

./bin/console doctrine:database:create

./bin/console doctrine:migrations:migrate

./bin/console doctrine:fixtures:load

symfony server:start

Login with demo user : user@test.com | password