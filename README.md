# Laravel JSON import test

This application is made to import a data file.
Currently it only accepts .json files.

## Installation

Start by installing [Docker](https://www.docker.com/). 

Use composer to install all laravel packages.
```bash
composer install
```
Then use yarn to install all front-end packages.

```bash
yarn install
```

Set an application key by running

```bash
php artisan key:generate
```

In order to start the docker container, you can run the following

```bash
./vendor/bin/sail up
```

Note: it's easier if you configure an [alias for sail](https://laravel.com/docs/10.x/sail#configuring-a-shell-alias);

After that is done you can run the migrations with

```bash
sail artisan:migrate
```

Finally, to start up the front-end run

```bash
yarn vite
```

## Usage

The application consists of a small front-end where you can upload .json files. 
Got to the address specified when you ran 'vite', drag and drop a json file into it and click on upload. 

In order to run and listen to the queue, use the following: 

```bash
sail artisan queue:listen
```