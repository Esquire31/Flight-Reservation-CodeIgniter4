# Flight Reservation System

![PHP](https://img.shields.io/badge/PHP-7.3%2B-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-orange)
![Full Stack](https://img.shields.io/badge/Full%20Stack-Application-brightgreen)

## Overview

The Flight Reservation System is a web application built using CodeIgniter 4, a PHP full-stack web framework that is light, fast, flexible, and secure. This system allows users to search for flights, make reservations, and manage bookings.

### Homepage
![App Screenshot](https://github.com/Esquire31/Walker2d-Deep-Reinforcement-Learning/blob/main/Examples/mujoco%202024-07-13%2012-22-44.gif)

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible, and secure. More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter. It has been built from the [development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found [here](https://codeigniter4.github.io/userguide/).

## Installation & Updates

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/flight-reservation-system.git
   ```

2. Navigate to the project directory:
   ```bash
   cd flight-reservation-system
   ```

3. Install dependencies using Composer:
   ```bash
   composer install
   ```

4. Whenever there is a new release of the framework, update the dependencies:
   ```bash
   composer update
   ```

5. Check the release notes to see if there are any changes you might need to apply to your `app` folder. The affected files can be copied or merged from `vendor/codeigniter4/framework/app`.

## Setup

1. Copy `env` to `.env` and tailor it for your app, specifically the `baseURL` and any database settings.

2. Set up your database and configure it in the `.env` file.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder, for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Features

- User registration and login
- Search for flights
- Book flights
- Manage bookings
- Receive booking confirmations via email
