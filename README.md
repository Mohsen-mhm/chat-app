<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About project

This is a real-time web chat app with Socket.io, Laravel-echo & Redis.

- **Laravel**
- **PHP**
- **Js**
- **Socket.io**
- **Laravel-echo**
- **Laravel-echo-server**
- **Redis**
- **Redis-server**

## Getting Started

Clone the project repository by running the command below if you use SSH

```bash
git clone git@github.com:Mohsen-mhm/chat-app.git
```

If you use https, use this instead

```bash
git clone https://github.com/Mohsen-mhm/chat-app.git
```

After cloning, run:

```bash
composer install
```

and:

```bash
npm install
```

Duplicate `.env.example` and rename it `.env`

Then run:

```bash
php artisan key:generate
```

-------------------------

### Prerequisites

#### install Redis

- [For Linux](https://redis.io/docs/getting-started/installation/install-redis-on-linux/)
- [For Mac](https://redis.io/docs/getting-started/installation/install-redis-on-mac-os/)
- [For Windows](https://github.com/tporadowski/redis/releases) - Use This repo to download and install Redis on Windows

-------------------------

#### Database Migrations

Be sure to fill in your database details in your `.env` file before running the migrations:

```bash
php artisan migrate
```

Run Redis server in cmd :

```bash
redis-server
```

Run Laravel echo server in cmd :

```bash
laravel-echo-server start
```

And finally, start the application:

```bash
php artisan serve
```

visit [http://localhost:8000](http://localhost:8000) to see the application in action.
