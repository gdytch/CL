# ComputerClass

![demo](https://github.com/gdytch/CL/blob/master/resources/assets/images/demo.PNG)

Beta Demo
### Demo [computerclassapp.herokuapp.com](https://computerclassapp.herokuapp.com)

A web application that manages the laboratory activities of students... (to be continued)...


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install theme

- XAMPP [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
- A text editor (Sublime, Atom, Etc.)
- Composer (windows installer) [https://getcomposer.org/download/](https://getcomposer.org/download/)



### Installation

For local machine

A step by step series of examples that tell you have to get a development env running

 - Install XAMPP and composer
 - Download the app (Select download -> download as zip)
 - Go to your htdocs folder found in your xampp installation folder and create a new folder for the app (ex. ComputerClass)
```
c:\xampp\htdocs     \\create a folder     c:\xampp\htdocs\ComputerClass
```
- Extract the all files from the downloaded zip to the folder you created
```
c:\xampp\htdocs\ComputerClass
```
 - After extracting the files, open CMD and go to your app folder
```
c:\Users\User\> cd c:\xampp\htdocs\computerclass
```
 - Then run the following:
 ```
composer install
php artisan vendor:publish --tag=lfm_public
php artisan vendor:publish --tag=ckeditor
 ```
 - This will install the necessary files for the app (internet connection required)


### Set up Database

 - Go to your phpmyadmin and create a database for the app
 - Go to your app folder and open the .env file
 - Set the variables for your database
 ```
  ...
     DB_CONNECTION=mysql
     DB_HOST=             \\your db host
     DB_PORT=3306
     DB_DATABASE=         \\your db
     DB_USERNAME=         \\your db username
     DB_PASSWORD=         \\your db password
  ...
 ```

### Database Migration

 - Migration will create the tables in your database. Run
```
php artisan migrate
```
 - (Optional) Your database tables are empty right now. If you want some initial data in the database you can run
 ```
 php artisan db:seed
 ```
 this will create an admin, students, sections, etc..
 For admin = username:admin      password:12345

## Run
To start the PHP built-in server
```
php artisan serve
```
or you can specify your host and port
```
php artisan serve --host 0.0.0.0 --port 8000
```
- You can now browse the app at [http://localhost:8000/](http://localhost:8000/)


## Getting Started with the App

(will explain how to use the app and how app works)
(instructions to follow)

```
Give an example
```


## Deployment

Add additional notes about how to deploy this on a live system
(instructions to follow)

## Built With

* [Laravel](https://laravel.com/docs/5.5) - The web framework used
* [ModularAdmin](https://github.com/modularcode/modular-admin-html) - The Dashboard theme used



## Authors

* **Dytch Genon** - [gdytch](https://github.com/gdytch)

## License

The Laravel framework is open-sourced software licensed under the MIT license.
