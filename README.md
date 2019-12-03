# Peer to Peer Video Calling

This is a Laravel application demonstrating peer to peer video calling using WebRTC APIs and Laravel WEbsockets used for singaling.

## Local Development
This is project is built with Laravel & Vue.js. The Laravel framework has a few system requirements. All of these requirements are satisfied by the [Laravel Homestead](https://laravel.com/docs/6.x/homestead) virtual machine.

However, if you are not using Homestead, you will need to make sure your local development server meets the following requirements:

### Installing Prerequisites

You can find the server prequisites listed in [laravel docs](https://laravel.com/docs/6.x#server-requirements), Additionally, you would require to install [composer](https://getcomposer.org/) & [nodejs](https://nodejs.org/en/) to pull in all the project dependencies.

### Clone Project
You can simply clone the project using `git` as:

```bash
git clone https://github.com/gautamswati/ducs-office-automation
```

### Install project dependencies

Go to the project directory and install php dependencies using `composer`:

```bash
composer install
```

`npm` to install all the required JavaScript dependencies.

```bash
npm install
```

To compile down the frontend assets like stylesheets (CSS) & javascript files using,

```
npm run dev
```

Or you can also run a watcher to automatically compile the assets, whenever the files are changed.

```
npm run watch
```

### Application Configuration

Create a duplicate file of `.env.example` as `.env`.

```bash
cp .env.example .env
```

To generate an application key use: 
`php artisan key:generate` this will add an application to your `.env` file. 

Setup Database connection in `.env` file:

```env
...
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
...
```
Make sure you change database configuration according to your credentials. Mostly, you'd need to change values for these variables:

- `DB_DATABASE` - This is the name of database, you must change this and make sure the database name you provide exists, or would get an error.
- `DB_USERNAME` - This is your mysql user.
- `DB_PASSWORD` - This is your mysql password for that user.

That's pretty much it. You're done with the configuration.

### Add some default data for testing the app
To create all the tables & seed your database with dummy users, run:

```bash
php artisan migrate --seed
```

This will create 5 Users with following email:
- John Doe (john@example.com)
- Jane Doe (jane@example.com)
- Mary Jane (mary@example.com)
- Tom (tom@example.com)
- Harry (harry@example.com)

You can login as any one of them, password for every user is `password`.

### Start Local Development Server

You'd need to start a local development server to see demo in action.

```bash
# start websockets server
php artisan websockets:serve

# start local php server
php artisan serve
```

You can now open `localhost:8000` in your browser, Create a Video Chat with another user and start trying out the demo.
