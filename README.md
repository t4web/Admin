# Admin

Skeleton for your ZF2 Application backend (Admin part). Build on [Admin LTE v2.0.5](https://github.com/almasaeed2010/AdminLTE)

## Contents
- [Installation](#instalation)
  - [Post installation](#post-installation)
  - [Css, Js, fonts and images](#css-js-fonts-and-images)
  - [Original theme](#original-theme)
- [Introduction](#introduction)
  - [Main menu](#main-menu)

## Installation

Add this project in your composer.json:

```json
"require": {
    "t4web/admin": "~2.0.0"
}
```

Now tell composer to download `T4web\Admin` by running the command:

```bash
$ php composer.phar update
```

#### Post installation

Enabling it in your `application.config.php`file.

```php
<?php
return array(
    'modules' => array(
        // ...
        'Sebaks\View',
        'Sebaks\ZendMvcController',
        'T4web\Admin',
    ),
    // ...
);
```

#### Css, Js, fonts and images

For normal working Admin module (and beautiful view), you can copy assets to your public:

```shell
$ mkdir public/css
$ mkdir public/js
$ mkdir public/img
$ cp -R vendor/t4web/admin/public/css public
$ cp -R vendor/t4web/admin/public/js public
$ cp -R vendor/t4web/admin/public/img public
```

#### Original theme

For inspiration and build you custom backend you may download whole theme to `public/theme`

```shell
$ mkdir public/theme
$ cd public/theme
$ wget https://github.com/almasaeed2010/AdminLTE/archive/v2.0.5.tar.gz
$ tar -zxvf v2.0.5.tar.gz
$ rm v2.0.5.tar.gz
```

## Introduction

Almost all backend contain: Dashboard, ability to managing content or custom entities of project, main menu. Managing
content contain: lists (with filters and pagers) and create\read\update forms. This solution provide this. With
`T4web\Admin` you can build CRUD for your Entities quickly and easy.

For template building we use [sebaks\view](https://github.com/sebaks/view)

We build backend for managing Users (for example) for describe configuration `T4web\Admin`.

After install we can see empty backend page on uri /admin
![empty backend page](http://teamforweb.com/var/admin-1.jpg)

#### Main menu

