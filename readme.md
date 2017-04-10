<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Img 图床

Img 是基于 https://sm.ms 的图床

通过 http://weibo.com/minipublish 上传图片，然后获取 URL

## Install

1. composer

`composer create-project --prefer-dist hanson/img:dev-master project`

2. git
```
git clone https://github.com/HanSon/img.git
cd img
composer install
```

在 `.env` 中配置 `WEIBO_USERNAME` 和 `WEIBO_PASSWORD` ，分别为个人的微博账号密码

然后运行 `php artisan serve` 访问 http://localhost:8000 即可

## Relevant Package

[laravel-base-project](https://github.com/HanSon/base-laravel-project) 基于最新版的 laravel 项目，自带一些常用的开发包

