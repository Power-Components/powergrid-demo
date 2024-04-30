<div align="center">
	<p><img  src="https://raw.githubusercontent.com/Power-Components/livewire-powergrid/main/art/header.jpg" alt="PowerGrid Header"></p>
</div>

# PowerGrid Demo

## About

This repository is a catalog of code examples using [Livewire PowerGrid v5](https://livewire-powergrid.com/) in a Laravel application.

The resources available here are aimed at helping the user get up and running as fast as possible, and also allow everyone to stay up-to-date with the latest PowerGrid features.

`🌎` See all examples live [here](https://demo.livewire-powergrid.com/).

`📚` Read the [PowerGrid Documentation](https://livewire-powergrid.com/) for more information about configuration and features.

`📦` Visit the [PowerGrid](https://github.com/Power-Components/livewire-powergrid) main repository to see the latest package features.

## Stack

- [Laravel 11](https://laravel.com/)
- [Livewire v3](https://laravel-livewire.com)

## Get Started

### Requirements

- [Git](https://github.com/git-guides/install-git)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- PHP 8.2+
- [Npm](https://www.npmjs.com/get-npm)
- A database (e.g. MySQL)

### Clone

Clone this repository and enter the project's directory.

```shell
git clone https://github.com/Power-Components/powergrid-demo.git && cd powergrid-demo
```

### Install

Install dependencies with Composer.

```shell
composer install
```

Compile the project assets.

```shell
npm install && npm run dev
```

## Configure your .env

Copy the `.env.example` into `.env`.

```shell
cp .env.example .env 
```

Set up the database credentials in `.env` file.

```shell
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=**your database name**
DB_USERNAME=**your database user**
DB_PASSWORD=**your database password**
```

Generate the application key.

```shell
php artisan key:generate
```

## Prepare your Database

Run the migrations and seeders.

```shell
php artisan migrate --seed
```

## Access the PowerGrid Demo

Serve your project:

```shell
php artisan serve
```

## Support

For questions, technical inquiries, bug reports and feature requests, please use the [PowerGrid](https://github.com/Power-Components/livewire-powergrid) official GitHub Repository.

<br/>

<hr>

<sup><b>Notice of Non-Affiliation and Disclaimer:</b> Livewire PowerGrid is not affiliated with, associated with, endorsed by, or in any way officially connected with the <a href="https://laravel-livewire.com" target="_blank">Laravel Livewire</a> - copyright by Caleb Porzio. Laravel is a trademark of Taylor Otwell.</sup>
