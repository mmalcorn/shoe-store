Clone this project by running the following command:

git clone http://www.github.com/mmalcorn/shoe-store.git

Change directories into the top level of the project by running:
cd shoe-store

Here you will run the command:
composer install

--This will load in the Silex and Twig dependencies used to create this project.

Change directories into the web folder by running:
cd web

In this folder (web), we will start a local server by running the command:
php -S localhost:8000

Make sure that you have an internet connection established.  Open your browser, and type the following:
localhost:8000

Must have:
-An internet connection
-MAMP, WAMP, or LAMP
-MySQL


Run this command at the terminal:
/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
In order to run the following lines to replicate the database used in this project:

  CREATE DATABASE shoes;
  USE shoes;
  CREATE TABLE brands (name VARCHAR (255), style VARCHAR (255), id serial PRIMARY KEY);

  INSERT INTO brands (name, style) VALUES ('Emilio Pucci', 'boot');
  INSERT INTO brands (name, style) VALUES ('Joie','bootie');
  INSERT INTO brands (name, style) VALUES ('Prada', 'hiking boot');
  INSERT INTO brands (name, style) VALUES ('Aquatalia', 'boot');
  INSERT INTO brands (name, style) VALUES ('Prada', 'sandal');

  CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR(255));
  INSERT INTO stores (name) VALUES ('Neiman Marcus');
  INSERT INTO stores (name) VALUES ('Lyst');
  INSERT INTO stores (name) VALUES ('Emilio Pucci');
  INSERT INTO stores (name) VALUES ('Prada');

  CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);

Copy the database from PHPMyAdmin into a shoes_test database by clicking on the 'operations' table, and typing copy database to: 'shoes_test'.  Select the structure only, not data.  Hit 'go'.
