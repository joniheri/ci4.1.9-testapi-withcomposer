# MAKE RESTful API USING CODEIGNITER 4

## Tes Running

- Ketikkan ini jika ingin melihan form login : http://localhost:8080/login
  !["JonheriAPITes Presentation"](https://github.com/joniheri/ci4.1.9-testapi-withcomposer/blob/master/screenshot/form_login.png "JonheriAPITes Presentation")

- Ketikkan ini jika ingin melihan form register : http://localhost:8080/register
  !["JonheriAPITes Presentation"](https://github.com/joniheri/ci4.1.9-testapi-withcomposer/blob/master/screenshot/form_register.png "JonheriAPITes Presentation")

## How To Installation Using Composer

- This is CodeIgniter versi 4.1.9
- Pastikan Composer sudah terinstall
- Disini develop menggunakan PHP Versi 8.1 atau bisa menggunakan XAMPP Versi 8
- Untuk menginstall CodeIgniter versi 4.1.9 ini menggunakan Composer, dengan cara mengetikkan di terminal "composer create-project codeigniter4/appstarter name-project --no-dev"
- Setelah terinstall, silahkan buka project CodeIgniter4 ini, kemudian ketiikan di terminal "php spark serve"
- Jika di terminal tampil "http://localhost:8080", brarti project CodeIgniter4 kita sudah bisa jalan di browser mdengan mengunjungi link "http://localhost:8080"

# CSS Framework

- Project ini menggunakan CSS framework Bootstrap 5 CDN

## Additional

- Video tutorial : https://www.youtube.com/watch?v=vKFcpQo-h-Q&t=43s
- File yang ditambahkan untuk cek "validasi input" ada di directory ./app/Helpers/Form_helper.php
- File yang ditambahkan untuk "hash password" ada di directory ./app/Libraries/Hash.php
- File yang ditambahkan untuk "filter" ada di directory ./app/Libraries/AuthCheckFilter.php

# DOCUMENTASION BY JON HERI

# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the _public_ folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's _public_ folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter _public/..._, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
