# ComputerClass

![demo](https://github.com/gdytch/CL/blob/master/resources/assets/images/demo.PNG)

Beta Demo
### Demo [computerclassapp.herokuapp.com](https://computerclassapp.herokuapp.com)

A web application that manages the laboratory activities of students... blah blah blah (to be continued)...


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
- XAMPP [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
- A text editor (Sublime, Atom, Etc.)
- Composer (windows installer) [https://getcomposer.org/download/](https://getcomposer.org/download/)

```

### Installation
For local machine
(instructions to follow)

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
c:\Users\User\ cd c:\xampp\htdocs\computerclass
```
 - Then run the following
 ```
composer install
 ```
 - This will install the necessary files for the app (internet connection required)
 - After that, run the app by typing
 ```
php artisan serve
 ```
 or you can specify your host and port
 ```
php artisan serve --host 0.0.0.0 --port 1334
 ```
- Go to your browser - localhost:8000

 (next setup your env variables)

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Laravel](https://laravel.com/docs/5.5) - The web framework used
* [ModularAdmin](https://github.com/modularcode/modular-admin-html) - The Dashboard theme used



## Authors

* **Dytch Genon** - [gdytch](https://github.com/gdytch)

## License

The Laravel framework is open-sourced software licensed under the MIT license.
