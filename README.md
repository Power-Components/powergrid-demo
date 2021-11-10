<div align="center">
	<p><img src="header.jpg" alt="PowerGrid Logo"></p>
</div>

# Demo Project

This is a demo project featured in a live code session at [Beer and Code](https://www.youtube.com/watch?v=Mml5aagMOm4&ab_channel=BeerandCode) Youtube channel.

❇️ Please check [PowerGrid](https://github.com/Power-Components/livewire-powergrid) main repository for the package most update version.

📚 See the [Documentation](https://livewire-powergrid.docsforge.com/) for more information about configuration and features.

## How to use

### Requirements

- [Git](https://github.com/git-guides/install-git)
- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
- PHP 7.4.1+
- [Npm](https://www.npmjs.com/get-npm)
- A database (e.g. MySQL)

### Clone

Clone this repository:

```
git clone https://github.com/Power-Components/powergrid-demo.git
```

Enter the project's directory:


```
cd powergrid-demo
```

### Install

```
composer update && composer install
```

npm
```
npm install && npm run dev
```

## Configure your .env

Copy the default file `.env.example` into `.env`

```
cp .env.example .env 
```

Set up the database credentials in `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=**your database name**
DB_USERNAME=**your database user**
DB_PASSWORD=**your database password**
```

Run the the migrations and seeders 

```
php artisan migrate --seed
```

Generate the application key

```
php artisan key:generate
```

Serve your project:
```
php artisan serve
```

Your PowerGrid component can be found at `app/Http/Livewire/DishesTable.php`.

## Support

For questions, issues, bug reports and feature requests, please use [PowerGrid](https://github.com/Power-Components/livewire-powergrid) official GitHub Repository.

Please look into our previous issues to verify if your bug/question or feature request has been previously submitted.

📣 Submit a [new issue](https://github.com/Power-Components/livewire-powergrid/issues).

<br/>

# 💓 Thank you for downloading!
