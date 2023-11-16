## About the test

This is a simple laravel 10 test project to manipulate the persons data. For this project you will need the following

- php 8.1 or above
- postgres database
- minimum knowledge of setting up a host

First clone this repository and follow the steps to make this work.

## First steps

You will need to setup your own environment from where you wish to run the laravel project. I have set in my own hosts file the following domain 127.0.0.1 ixentest.local. In the rest of the example I will use this as reference but you can choose what fits you the best.

When the above is set go to the cloned project and change the .env.exmaple file to .env. In the env file you will need to setup your database access:
```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=ixentest
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

## Basic logic for the database
The main table is the **persons** and have relations to **person_address**. On PersonAddress table the person_id is unique and the person can have only one address inserted.
The other relation would be the **person_contact** where there is 2 fields what can be populated. There is no limit how many contacts can one user have. We need to insert type and value for the contact. It should be predefined that the type can be email, mobile etc while the value should be the contact itself.

## Api requests
### Returns all person data.
```
http://ixentest.local/api/list
Type: GET
Response: JSON Array
Example:
[
    {
        "id": 7,
        "first_name": "Jaunita",
        "last_name": "Ondricka",
        "created_at": "2023-11-16T12:47:39.000000Z",
        "updated_at": "2023-11-16T12:57:04.000000Z",
        "person_contacts": [
            {
                "id": 1,
                "person_id": 7,
                "contact_type": "email",
                "contact_value": "email@ads.com",
                "created_at": "2023-11-16T12:47:39.000000Z",
                "updated_at": "2023-11-16T12:47:39.000000Z"
            },
            {
                "id": 2,
                "person_id": 7,
                "contact_type": "mobile",
                "contact_value": "+3520123456",
                "created_at": "2023-11-16T12:47:39.000000Z",
                "updated_at": "2023-11-16T12:47:39.000000Z"
            }
        ],
        "person_address": {
            "id": 7,
            "person_id": 7,
            "permanent_address": "7357 Drew Corners Apt. 785",
            "temporary_address": "31095 Bednar Lock Suite 234",
            "created_at": "2023-11-16T12:47:39.000000Z",
            "updated_at": "2023-11-16T12:57:04.000000Z"
        }
    }
]
```

### Creates new person with data.
```
http://ixentest.local/api/create
Type: POST
Response: JSON Array
Example of fields:
first_name:Valkyr
last_name:Ullrich
permanent_address:1234 Citty Street 1
person_contacts[0][contact_type]:email
person_contacts[0][contact_value]:email2@ads.com
person_contacts[1][contact_type]:mobile
person_contacts[1][contact_value]:+3520123456

Success example:
{
    "id": 8,
    "first_name": "Valkyr",
    "last_name": "Ullrich",
    "created_at": "2023-11-16T13:06:47.000000Z",
    "updated_at": "2023-11-16T13:06:47.000000Z",
    "person_contacts": [
        {
            "id": 3,
            "person_id": 8,
            "contact_type": "email",
            "contact_value": "email2@ads.com",
            "created_at": "2023-11-16T13:06:47.000000Z",
            "updated_at": "2023-11-16T13:06:47.000000Z"
        },
        {
            "id": 4,
            "person_id": 8,
            "contact_type": "mobile",
            "contact_value": "+3520123456",
            "created_at": "2023-11-16T13:06:47.000000Z",
            "updated_at": "2023-11-16T13:06:47.000000Z"
        }
    ],
    "person_address": {
        "id": 8,
        "person_id": 8,
        "permanent_address": "1234 Citty Street 1",
        "temporary_address": "",
        "created_at": "2023-11-16T13:06:47.000000Z",
        "updated_at": "2023-11-16T13:06:47.000000Z"
    }
}

Error example:
{
    "errors": {
        "last_name": [
            "The last name field is required."
        ]
    },
    "status": 400
}
```
### Returns single person data.
In the request {person} expects person id.
```
http://ixentest.local/api/edit/{person}
Type: GET
Response: JSON Array
Success example:
{
    "id": 8,
    "first_name": "Valkyr",
    "last_name": "Ullrich",
    "created_at": "2023-11-16T13:06:47.000000Z",
    "updated_at": "2023-11-16T13:06:47.000000Z",
    "person_contacts": [
        {
            "id": 3,
            "person_id": 8,
            "contact_type": "email",
            "contact_value": "email2@ads.com",
            "created_at": "2023-11-16T13:06:47.000000Z",
            "updated_at": "2023-11-16T13:06:47.000000Z"
        },
        {
            "id": 4,
            "person_id": 8,
            "contact_type": "mobile",
            "contact_value": "+3520123456",
            "created_at": "2023-11-16T13:06:47.000000Z",
            "updated_at": "2023-11-16T13:06:47.000000Z"
        }
    ],
    "person_address": {
        "id": 8,
        "person_id": 8,
        "permanent_address": "1234 Citty Street 1",
        "temporary_address": "",
        "created_at": "2023-11-16T13:06:47.000000Z",
        "updated_at": "2023-11-16T13:06:47.000000Z"
    }
}

On missing person example:
{
  "message": "Record not found."
}
```
### Updates single person data.
In the request {person} expects person id.
Response is the updated person data.
> When updating the person_contacts the form need to have the previous rows other way it will be deleted
```
http://ixentest.local/api/person/update/{person}
Type: POST
Response: JSON Array
Success example:
{
    "id": 7,
    "first_name": "Jaunita",
    "last_name": "Ondricka",
    "created_at": "2023-11-16T12:47:39.000000Z",
    "updated_at": "2023-11-16T12:57:04.000000Z",
    "person_contacts": [
        {
            "id": 1,
            "person_id": 7,
            "contact_type": "email",
            "contact_value": "email@ads.com",
            "created_at": "2023-11-16T12:47:39.000000Z",
            "updated_at": "2023-11-16T12:47:39.000000Z"
        },
        {
            "id": 2,
            "person_id": 7,
            "contact_type": "mobile",
            "contact_value": "+3520123456",
            "created_at": "2023-11-16T12:47:39.000000Z",
            "updated_at": "2023-11-16T12:47:39.000000Z"
        }
    ],
    "person_address": {
        "id": 7,
        "person_id": 7,
        "permanent_address": "7357 Drew Corners Apt. 785",
        "temporary_address": "31095 Bednar Lock Suite 234",
        "created_at": "2023-11-16T12:47:39.000000Z",
        "updated_at": "2023-11-16T12:57:04.000000Z"
    }
}

Error example:
{
    "errors": {
        "last_name": [
            "The last name field is required."
        ]
    },
    "status": 400
}
```
### Deletes person and its relation data.
```
http://ixentest.local/api/destroy/{person}
Type: GET
Response: bool
Success example:
{
  "success": true
}

On missing person example:
{
  "message": "Record not found."
}
```

## Api requests test

To test are the api requests working I have used Laravel built in Tester. I have set all api request in PersonApiTest and we can test it with the following command:
```
php artisan test
```
