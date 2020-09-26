# Items Site
Items Management Site

* to run this sites please done this steps : 
* 1- go to folder project.
* 2- run `composer install`.
* 3- run `npm install`.
* 4- run `cp .env.example .env`.
* 5- go to .env file.
* 6- fill the following database details:
```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
```
* run `php artisan migrate`
* 7- run the project using this command `php artisan serv`:
* then go to http://127.0.0.1:8000
* You need to create a new account in site.
* after login will redirect to the main page of Items Management Site
