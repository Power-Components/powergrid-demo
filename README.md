<div align="center">
	<p><img src="header.jpg" alt="PowerGrid Logo"></p>
</div>

# Demo Project

This repository provides a fully configured PowerGrid implementation on a [Laravel 9](https://laravel.com/) project.

⚡ Check the PowerGrid Table: [app/Http/Livewire/DishesTable.php](https://github.com/Power-Components/powergrid-demo/blob/main/app/Http/Livewire/DishesTable.php).

<br/>

😎 This repository is kept up-to-date so you can use it as reference for your projects.

📚 See the [Documentation](https://livewire-powergrid.com/) for more information about configuration and features.

❇️ Visit [PowerGrid](https://github.com/Power-Components/livewire-powergrid) main repository to see the latest changes on the package.

<br/>

This PowerGrid example was originally created for a living code session at [Beer and Code](https://www.youtube.com/watch?v=Mml5aagMOm4&ab_channel=BeerandCode) Youtube channel.

<br/>

<sup><b>Notice of Non-Affiliation and Disclaimer:</b> Livewire PowerGrid is not affiliated, associated, endorsed by, or in any way officially connected with the Laravel Livewire - copyright by Caleb Porzio.</sup>

<br/>

## How to use

### Requirements

- [Git](https://github.com/git-guides/install-git)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- PHP 8.0+
- [Npm](https://www.npmjs.com/get-npm)
- A database (e.g. MySQL)

### Clone

Clone this repository and enter the project's directory:

```shell
git clone https://github.com/Power-Components/powergrid-demo.git && cd powergrid-demo
```

### Install

Install dependencies with Composer:

```shell
composer install
```

Compile the project assets:

```shell
npm install && npm run dev
```

## Configure your .env

Copy the `.env.example` into `.env`

```shell
cp .env.example .env 
```

Set up the database credentials in `.env` file:

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

## Tests

This repository comes with starter tests written in [Pest PHP](http://pestphp.com).

To run tests, execute:

```php
php artisan test
```

## Support

For questions, issues, bug reports and feature requests, please use [PowerGrid](https://github.com/Power-Components/livewire-powergrid) official GitHub Repository.

Please look into our previous issues to verify if your bug/question or feature request has been previously submitted.

📣 Submit a [new issue](https://github.com/Power-Components/livewire-powergrid/issues).

<br/>

<h1><code>💓 Thank you for downloading!</code></h1>
