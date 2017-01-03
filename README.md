# Shoe Store

##### _Shoe Store Management App_

#### By _Meredith Alcorn_

## Description

_This website allows users to add, edit, and delete shoe stores to a database.  Users may also add, edit, and delete brands to a database. Stores carry many brands, and many brands are carried at many stores--therefore, this site demonstrates a many-to-many relationship between these two entities.  Brands can be added to shoe stores, and shoe stores can be added to brands.  A join table is used to save this relationship to the database._

## Setup

 * Clone this repository: run the command ```git clone https://github.com/mmalcorn/shoe-store ``` then change directory to top level of project folder.
 * Use Composer to install dependencies: run command ```composer install ``` to download vendor files for Silex, Twig, and PHPUnit.
 * A local SQL server is needed to run the app.  MAMP or WAMP, for example.
 * Point your server to the shoe-store folder.  Open up PHPMyAdmin, and import the database located in the "dbbackup" folder.
 * Instead of importing the database, you may also create the database from scratch with a few lines.  In your terminal, type: ```/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot```.  Then, use the following commands:

```console
> CREATE DATABASE shoes;
> USE shoes;
> CREATE TABLE stores (store_name VARCHAR (255), id serial PRIMARY KEY);
> CREATE TABLE brands (brand_name VARCHAR (255), id serial PRIMARY KEY);
> CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);
```
* Start your server in the '/web' folder: to use PHP's built-in server, run command ```php -S localhost:8000```.
* View the app: in your browser, navigate to the home page at the root address. If running a server as described above, go to http://localhost:8000.

* To run the tests that have been created within this project,
1)  Copy the database from PHPMyAdmin into a shoes_test database by clicking on the 'operations' table.
2)  Then, copy the database to: 'shoes_test'.  Select the structure only, and hit 'go'.
3) Now in the command line at the top level of the project directory you may run the line ```phpunit tests```


## Technologies Used

_PHP, Composer (Silex, Twig, PHPUnit), MAMP, MySQL_

### Legal

Copyright (c) 2016 Meredith Alcorn

This software is licensed under the MIT license.
