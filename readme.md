# Простое MVC приложение на PHP

Создавать мы его будем на базе созданного ранее фреймворка. Для начала создадим новую базу данных, изменить параметры подключения к БД в конфиге и создадим две таблицы в БД:

```sql
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `create_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## Базовая настройка

В начале почистим контроллер:

*app/controllers/Pages.php*

```php
<?php

class Pages extends Controller{
    public function __construct(){
    }

    public function index(){
        $data = [
            'title' => 'Simple MVC',
            'description' => 'Simple social network built on the Custom PHP framework'
        ];

        $this->view("pages/index", $data);
    }

    public function about(){
        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts with other users'
        ];

        $this->view("pages/about", $data);
    }
}
```

В конфиг добавим ещё одну константу, которая будет выводить версию нашего приложения:

*app/config/config.php*

```php
<?php

// DB params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'simplemvc');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', 'http://simplemvc.loc');
// Site Name
define('SITENAME', 'Simple MVC');
// App Version
define('APPVERSION', '1.0.0');
```

Мы будем использовать Bootstrap и Font Awesome, поэтому подключим их, а также добавим подключение отдельного шаблона с навигацией:

*app/views/inc/header.php*

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/style.css">
    <title>
        <?php echo SITENAME; ?>
    </title>
</head>

<body>
    <?php require APPROOT . '/views/inc/navbar.php'; ?>
    <div class="container">
```

Теперь добавим разметку для навигации:

*app/views/inc/navbar.php*

```php
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URLROOT; ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">About</a>
            </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
            </li>
        </ul>
    </div>
</nav>
```

В футере подключим необходимые скрипты:

*app/views/inc/footer.php*

```php
    </div>

<script src="<?php echo URLROOT ?>/js/jquery.min.js"></script>
<script src="<?php echo URLROOT ?>/js/popper.min.js"></script>
<script src="<?php echo URLROOT ?>/js/bootstrap.min.js"></script>
<script src="<?php echo URLROOT ?>/js/main.js"></script>
</body>
</html>
```

Осталось поправить виды:

*app/views/pages/index.php*

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="jumbotron jumbotron-flud text-center">
        <div class="container">
        <h1 class="display-3"><?php echo $data['title']; ?></h1>
        <p class="lead"><?php echo $data['description']; ?></p>
        </div>
    </div> 
<?php require APPROOT . '/views/inc/footer.php'; ?>
```

*app/views/pages/about.php*

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="jumbotron jumbotron-flud text-center">
        <div class="container">
        <h1 class="display-3"><?php echo $data['title']; ?></h1>
        <p class="lead"><?php echo $data['description']; ?></p>
        </div>
    </div> 
<?php require APPROOT . '/views/inc/footer.php'; ?>
```