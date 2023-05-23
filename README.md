antic-api
=======

[![PHP8](https://img.shields.io/badge/Language-PHP8-blue?style=flat-square&logo=PHP)](https://github.com/dogeow/antic-api)
[![codecov](https://codecov.io/gh/dogeow/antic-api/branch/master/graph/badge.svg?token=QJ7RYCXO96)](https://codecov.io/gh/dogeow/antic-api)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

[中文](README_ZH.md)

## Intro

Personal study project.

Use frontend and backend separation.

## Build

1. Laravel
    1. composer install
    2. cp .env.example .env
        * modify DB and other
    3. php artisan migrate
    4. php artisan key:generate
    5. php artisan storage:link
2. React
    1. npm install
    2. Build
        * development: npm run dev
        * Production: npm run prod
3. Web Server：php artisan serve

## Powered by

* Laravel 9
* React 17
* Material-UI 5

## Server

* Ubuntu 20.04.4 LTS
* Nginx 1.18.0(nginx-full)
* MySQL 8.0.27
* PHP 8.1.5

## Acknowledgements

### Project supported by JetBrains

Many thanks to [Jetbrains](https://www.jetbrains.com/) for kindly providing a [Licenses for Open Source Development](https://jb.gg/OpenSourceSupport) for me to work on this open-source projects.

[![](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://jb.gg/OpenSourceSupport)

### Laravel China Community

[LearnKu.com](https://learnku.com) provides Laravel translation documents that everyone can use, and the website UI
interface is illuminated and edited, allowing me to easily get started with Laravel.

## License

This software is released under the MIT license.

[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fdogeow%2Fantic-api.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fdogeow%2Fantic-api?ref=badge_large)
