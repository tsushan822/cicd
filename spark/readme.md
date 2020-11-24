#Lease accounting app

Step 1:- git clone

Step 2:-Set env variables,
add SESSION_DOMAIN=.zenleases.com 

Step 3:-
create system database follow these for mysql
CREATE DATABASE IF NOT EXISTS zenlease;
CREATE USER IF NOT EXISTS zenlease@localhost IDENTIFIED BY 'someRandomPassword';
GRANT ALL PRIVILEGES ON *.* TO zenlease@localhost WITH GRANT OPTION;

For details and postgres database setup follow this link
https://tenancy.dev/docs/hyn/5.4/installation
This comes with hyn package to maintain tenant configuration.

Step 4:- run composer update

Step 5:- Then run migrate command  with
php artisan migrate --database=system

Step 6:- Run seeder command
php artisan db:seed --class=SystemDatabaseSeeder

Step 7:- Create first environment from browser and put emails for developer

Step 8:- Put SERVER_LEVEL as "prod" or "dev" in env file