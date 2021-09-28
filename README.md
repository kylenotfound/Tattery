<h1>Tattoo Gallery</h1>
This repo is a web-app made with friends where they can display a portfolio of photos of the tattoos they have, while also learning about front end web development, version control and get a taste for working in php/laravel.

<h2>Setup Instructions to Collaberate</h2>
I am leaving this repo open for anyone to contribute.

## Prerequistes
Have the following installed:
### Windows:
* [PHP 7.4](https://windows.php.net/download#php-7.4)
* [Composer](https://getcomposer.org/)
* [Git](https://git-scm.com/downloads)
* [MySql](https://dev.mysql.com/downloads/installer/) / [MySql Workbench](https://dev.mysql.com/downloads/workbench/)

### Mac:
>brew install php@7.4

>brew install composer

>brew install git

>brew install mysql

and the workbench (link above)

### Once all the above are installed, clone the repository:
>git clone (repo)

Now set up your database schema in the MySql Workbench:
Your schemea can be titled whatever you like, I named mine: "tattoo_gallery"

### Configure your .env
The .env file is not committed to github, but the .env.example file is
>Create a new file called .env in the root of your project directory

>Copy the boilerplate keys and values from the .env.example file into your new .env file

>Set your "DB_USERNAME", "DB_PASSWORD", "DB_DATABASE" values

Everything else should be set correctly from the .env.example file

Mine personally are 'root' and 'passoword' but these can be whatever you set up when configuring MySql workbench.
>Set "DB_DATABASE" to whatever you named your schema, eg. "tattoo_gallery"

### Now that your database is setup, run the following commands:
>composer install

If on windows, you may need to run 
>composer install --ignore-platform-reqs

>php artisan migrate

If you run this and it fails, or if you have just installed php for the first time, you may need to locate the source of where you installed php and edit your php.ini file and uncomment the following extensions. (remove the semicolons before each line)
* extension=php_mysql
* extension=php_mysqli
* extension=php_pdo_mysql
* extension=php_intl
* extension=php_curl
* extension=php_bz2
* extension=php_exif
* extension=php_mbstring
* extension=php_pdo_sqlite

If you had a terminal session open, be sure to restart it and then run:
>php artisan db:wipe
>php artisan migrate

All the migrations should have run now succesfully.

## To launch the devlopment server:

>php artisan serve

In your web browser of choice, go to: http://localhost:8000 and you should see the main landing page.

### Congratulations, your enviornment is all set up! But now what?

To get started working on a feature or fix, do the following:
Ensure you are on the master branch and:
>git branch feature/your-feature-name

>git checkout feature/your-feature-name

When ready to push commits:

>git push origin feature/your-feature-name
