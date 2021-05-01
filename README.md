<div align="center">
	<p><img  src="logo.png" alt="PowerGrid Logo"></p>
</div>

# Demo Project

This is a demo project featured in a live code session at [Beer and Code](https://www.youtube.com/watch?v=Mml5aagMOm4&ab_channel=BeerandCode) Youtube channel.

❇️ Please check [PowerGrid](https://github.com/Power-Components/livewire-powergrid) main repository for the component most up-to-date version and documentation.

## How to use

### Requirements

- Git
- Composer
- PHP 7.4+
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
composer install
```
npm
```
npm install && npm run dev
```

## Configure your .env

Set up the database in .env:

```
php artisan migrate --seed
```

```
php artisan key:generate
```

Serve your project:
```
php artisan serve
```
