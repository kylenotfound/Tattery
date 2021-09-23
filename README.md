<h1>Tattoo Gallery</h1>
This repo is a web-app made with friends where they can display a portfolio of photos of the tattoos they have, while also learning about front end web development, version control and get a taste for working in php/laravel.

<h2>Setup Instructions to Collaberate</h2>
I am leaving this repo open for anyone to contribute.

### Prerequistes
Have the following installed:
* [PHP 7.4](https://windows.php.net/download#php-7.4)
* [Composer](https://getcomposer.org/)
* [Git](https://git-scm.com/downloads)
* [MySql](https://dev.mysql.com/downloads/workbench/)

### Once all the above are installed, clone the repository:
>git clone (repo)

Now set up your database schema in the MySql Workbench:
Your schemea can be titled whatever you like, I named mine: "tattoo_gallery"

### Configure your .env
The .env file is not committed to github, but the .env.example file is
>Create a new file called .env in the root of your project directory

>Copy the boilerplate keys and values from the .env.example file into your new .env file

>Set your "DB_USERNAME", "DB_PASSWORD" values

Mine personally are 'root' and 'passoword' but these can be whatever you set up when configuring MySql workbench.
>Set "DB_DATABASE" to whatever you named your schema, eg. "tattoo_gallery"

### Now that your database is setup, run the following commands:
>composer install

>php artisan migrate

>php artisan serve

In your web browser of choice, go to: http://localhost:8000 and you should see the main landing page.

### Congratulations, your enviornment is all set up! But now what.

To get started working on a feature or fix, do the following:
Ensure you are on the master branch and:
>git branch feature/your-feature-name

>git checkout feature/your-feature-name

When ready to push commits:

>git push origin feature/your-feature-name
