antic-api
=======

[![codecov](https://codecov.io/gh/likunyan/antic-api/branch/master/graph/badge.svg?token=QJ7RYCXO96)](https://codecov.io/gh/likunyan/antic-api)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![github-stars-image](https://img.shields.io/github/stars/likunyan/antic-api.svg?label=github%20stars)](https://github.com/likunyan/html5-antic-api)
[![Donate](https://img.shields.io/badge/donate-paypal-blue.svg?style=flat-square)](https://paypal.me/likunyan?locale.x=zh_XC)

[English](README_en.md)

## 项目简介

个人学习用。使用前后端分离：Laravel + React。

学以致用，比如

- API 应用
- 半自动化
- 信息查看
- 日后可快速使用

## 一些功能

- 登录注册
- Markdown 编辑器
- Todo 待办事项
- 夜晚模式
- 一些 便民API

## 项目维护

有学有需求就会有更新，基本上算是日常更新

## 构建

1. Laravel
    1. composer install
    2. cp .env.example .env
        * 修改 DB 和其他
    3. php artisan migrate
    5. php artisan key:generate
    6. php artisan storage:link
2. React
    1. npm install
    2. 构建
        * development: npm run dev
        * Production: npm run prod
3. Web 服务：php artisan serve

## 版本

* Laravel 9
* React 17
* Material-UI 5

## 服务器

* Ubuntu 20.04.4 LTS
* Nginx 1.18.0(nginx-full)
* MySQL 8.0.27
* PHP 8.1.5

## 鸣谢

[LearnKu.com](https://learnku.com) 提供了人人可编辑的 Laravel 翻译文档，而且网站 UI 界面简洁优雅，让我愉快且方便地入门了 Laravel。
