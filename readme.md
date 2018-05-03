# Простое MVC приложение на PHP

## Начало работы и схема базы данных

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
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">About</a>
                </li>
            </ul>
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
                </li>
            </ul>
        </div>
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

## Создание контроллера Users

Создадим контроллер, в котором мы пока что просто проверим, если данные не отправляются методом POST, тогда просто выводим форму (пока что просто сообщение).

*app/controllers/Users.php*

```php
<?php

class Users extends Controller{
    public function __construct(){

    }

    public function index(){
        echo 'User index';
    }

    public function register(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process the form
        }
        else{
            // Load form
            echo 'User register form';
        }
    }
}
```

По клику на ссылку регистрации в меню мы должны обращатся к нашему контроллеру и методу `register()`. Теперь давайте инициализируем данные и подгрузим вид:

*app/controllers/Users.php*

```php
<?php

class Users extends Controller{
    public function __construct(){

    }

    public function index(){
        echo 'User index';
    }

    public function register(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process the form
        }
        else{
            // Load form
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->view('users/register', $data);
        }
    }
}
```

Создадим вид:

*app/views/users/register.php*

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create An Account</h2>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
```

## Виды для формы регистрации и авторизации

По сути это просто разметка Bootstrap и единственное, что здесь может вызвать вопросы это конструкция `<?php echo !empty($data['name_err']) ? 'is-invalid' : ''; ?>`, где мы с помощью тернарного оператора присваиваем класс `is-invalid` для инпута, когда в массив попадает значение с ошибкой. С валидацией формы мы поработаем чуть позже и всё станей яснее:

*app/views/users/register.php*

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create An Account</h2>
                <p>Please fill out this form to register with us</p>
                <form action="<?php echo URLROOT; ?>/users/register" method="POST">
                    <div class="form-group">
                        <label for="name">Name: <sup>*</sup></label>
                        <input type="text" name="name" class="form-control form-control-lg <?php echo !empty($data['name_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name'] ?>">
                        <span class="invalid-feedback"><?php echo data['name_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="text" name="email" class="form-control form-control-lg <?php echo !empty($data['email_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <span class="invalid-feedback"><?php echo data['email_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="text" name="password" class="form-control form-control-lg <?php echo !empty($data['password_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password'] ?>">
                        <span class="invalid-feedback"><?php echo data['password_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                        <input type="text" name="confirm_password" class="form-control form-control-lg <?php echo !empty($data['confirm_password_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password'] ?>">
                        <span class="invalid-feedback"><?php echo data['confirm_password_err'] ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
```

Добавим метод `login()` в контроллер `User`:

*app/controllers/Users.php*

```php
public function login(){
    // Check for POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process the form
    }
    else{
        // Load form
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
        ];
        $this->view('users/login', $data);
    }
}
```

Вид, очень поход на предыдущий - мы просто убрали лишнее:

*app/views/users/login.php*

```php
<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Login</h2>
                <p>Please fill in your credentials to log in</p>
                <form action="<?php echo URLROOT; ?>/users/register" method="POST">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="text" name="email" class="form-control form-control-lg <?php echo !empty($data['email_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <span class="invalid-feedback"><?php echo data['email_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="text" name="password" class="form-control form-control-lg <?php echo !empty($data['password_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password'] ?>">
                        <span class="invalid-feedback"><?php echo data['password_err'] ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT ?>/users/register" class="btn btn-light btn-block">No account? Register</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
```