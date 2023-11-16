## About the test

This is a simple laravel 10 test project to manipulate the persons data. For this project you will need the following

- php 8.1 or above
- postgres database
- minimum knowledge of setting up a host

First clone this repository and follow the steps to make this work.

## First steps

You will need to setup your own environment from where you wish to run the laravel project. I have set in my own hosts file the following domain 127.0.0.1	persons.local. In the rest of the example I will use this as reference but you can choose what fits you the best.

When the above is set go to the cloned project and change the .env.exmaple file to .env. In the env file you will need to setup your database access:
```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=ixen
DB_USERNAME=admin
DB_PASSWORD=secret
```
The above data are my own local setup so you can create what fits you the best. The database name is not mandatory to be ixen it can be anything what fits you the best.

## Initialising

All commands should be run from the project folder.

When the database is set you need to run the following command:
```
composer upgrade
```
After this you need to create the database structure by running the following command:
```
php artisan migrate
```

This project doesn't have API but the function would be the following:
The main table would be the person and have relations to person_address. On PersonAddress table the person_id is unique and the person can have only one address inserted.
The other relation would be the person_contact where there is 2 fields what can be populated. There is no limit how many contacts can have one user. We need to insert type and value for the contact. It should be predefined that the type can be email, mobile etc while the value should be the contact itself.
