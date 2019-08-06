# music-collection

## Dependencies

* symfony 4.4
* php
* mysql server


## Install

git clone https://github.com/jnewmar/music-collection.git

cd music-collection/music-collection/

For local env, set the variable CLEARDB_DATABASE_URL) with the mysql connection string. Ex : mysql://laravel:password@127.0.0.1:3306/music

composer install

./bin/console doctrine:database:create

./bin/console doctrine:migrations:migrate

./bin/console doctrine:fixtures:load

symfony server:start

Login with demo user : user@test.com | password