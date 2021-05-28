# Simple CRUD Shopping Card
This document aims to implement Simple CRUD Shopping Card in Reatjs, Laravel and Codeigniter.

# Requirements
* Front-end:<br>
	○ ReactJS<br>
	○ Must have a section to manage products (CRUD)<br>
		■ User should be able to manage product name, price, image and quantity.<br>
		■ There is no need to create a login system.<br>
	Shopping cart<br>
		■ The cart will need to keep its “state” during page loads / refreshes<br>
		■ List Products – these should be listed at all times to allow adding of products<br>
		■ Products should be listed in this format: product name, price, link to add product<br>
		■ Must be able to add a product to the cart<br>
		■ Must be able to view current products in the cart<br>
		■ Cart products should be listed in this format: product name, price, quantity, total, remove link<br>
		■ Product totals should be tallied to give an overall total<br>
		■ Must be able to remove a product from the cart<br>
		■ Adding an existing product will only update existing cart product quantity (e.g. adding the same product twice will NOT create two cart items)<br>
		■ All prices should be displayed to 2 decimal places<br>
* Back-end:<br>
	○ Project will work as expected in PHP 7.3+<br>
	○ We require the back-end to be developed with two Frameworks. The final outcome should be two APIs<br> developed with the following Frameworks and both APIs should return the same information:
		■ Codeigniter 3.0<br>
		■ Laravel 8+<br>
	○ Error checking will be set to strict for viewing completed code<br>
* Use MySQL<br>
	○ Create the necessary tables for products:<br>
		■ uid<br>
		■ name<br>
		■ price<br>
		■ Image<br>
		■ stock<br>

# Deployments
## Prerequisites
* Nodejs
* Php 8.+
* Composer
* MySQL

## Download
```
$ git clone https://github.com/jorenaud/crud_shopping_cart.git
```

## Install and start Back-end
### Database configuration
Create the database named as "shop", "utf8mb4" as a char_set, and "utf8mb4_general_ci" as dbcollat in mysql console

```
>create database shop;
```

### Laravel
* Database settings
Open .env file in Laravel directory and set the DB host, username, and password.
* Database migration
```
$ cd Laravel/
$ php artisan migrate

```
* Start
```
$ php artisan serve
```
* Confirmation
Open browser and goto 'http://localhost:8000/'


### Codeigniter
* Database settings
Open application/config/database.php file in Codeigniter directroy and set the DB host, username, and password.

* Start
```
$ cd Codeigniter/
$ php spark servie --port=80
```

* Confirmation
Open browser and goto 'http://localhost/'


## Install and start frontend
* API Configuration
Open src/const.js file in ReactJS directory, and Settings the "BASE_API_URL". 
If you want to use Laravel API,...
	- export const BASE_API_URL = "http://localhost:8000";
If you want to use Codeigniter API,...
	- export const BASE_API_URL = "http://localhost";

* Start
```
$ cd ReactJS/
$ npm install
$ npm start
```

* Confirmation
Open browser and goto 'http://localhost:3000/'

