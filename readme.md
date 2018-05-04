# Простое MVC приложение на PHP

## Начало работы и схема базы данных

Создавать мы его будем на базе созданного ранее фреймворка. Для начала создадим новую базу данных, изменить параметры подключения к БД в конфиге и создадим две таблицы в БД:

```sql
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
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
                        <span class="invalid-feedback"><?php echo $data['name_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo !empty($data['email_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo !empty($data['password_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password'] ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo !empty($data['confirm_password_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password'] ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_password_err'] ?></span>
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
                <form action="<?php echo URLROOT; ?>/users/login" method="POST">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo !empty($data['email_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email'] ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo !empty($data['password_err']) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password'] ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err'] ?></span>
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

## Валидация формы

Во время отправки и обработки данных нам нужно чтобы данные были заполненны, а поля с ошибками оставались пустыми. Мы проверяем что именно вводит пользователь и если это не соответствует нашим требованиям, то мы заполняем массив ошибками и затем выводим их в вид. Не забываем предварительно фильтровать данные.

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
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Process the form
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            // Validate Name
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter name';
            }
            // Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }
            // Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }
            else if(strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            // Validate Confirm Password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            }
            else if($data['password'] != $data['confirm_password']){
                $data['confirm_password_err'] = 'Password do not match';
            }
            // Make sure errors are empty
            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                die('VALIDATED');
            }
            else{
                // Load view with errors
                $this->view('users/register', $data);
            }
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

    public function login(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Process the form
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];
            // Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }
            // Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }
            else if(strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])){
                die('VALIDATED');
            }
            else{
                // Load view with errors
                $this->view('users/login', $data);
            }
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
}
```

## Модель User и проверка email

Во время регистрации нам нужно проверять не существует ли уже пользователь с указанным email. Чтобы это проверть нам нужно создать предварительно тестовые данные:

```sql
INSERT INTO `users` VALUES ('1', 'Jonh Doe', 'j.doe@gmail.com', '123456', '2018-05-04 12:16:35');
INSERT INTO `users` VALUES ('2', 'Vladimir Kamuz', 'v.kamuz@gmail.com', '123456', '2018-05-04 12:16:30');
```

Тепер создадим модель `User`:

*app/models/User.php*

```php
<?php

class User{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // Find user by email
    public function findUserByEmail($email){
        $this->db->query('SELECT email FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if($this->db->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
```

Здесь мы описываем функцию `findUserByEmail()` в котором проверим переданный email с тем если такой же в БД и если такой email уже имеется в БД, то есть мы находим совпадение в БД, то мы создадим новое сообщение об ошибке валидации:

*app/controllers/Users.php*

```php
//..
// Validate Email
if(empty($data['email'])){
    $data['email_err'] = 'Please enter email';
}
else if($this->userModel->findUserByEmail($data['email'])){
    $data['email_err'] = 'Email is already taken';
}
```

## Регистрация пользователя

Перед тем как двигаться дальше, давайте вначале захешируем наш пароль, а затем в случае успешной записи в БД  сделаем редирект на страницу логина с помощью собственной функции, которую мы определим в хелпере.

*app/controllers/Users.php*

```php
    // Validated

    // Hash Password
    $data['password'] = password_hash($data['passworld'], PASSWORD_DEFAULT);

    // Register users
    if($this->userModel->register($data)){
        redirect('/users/login');
    }
    else{
        die('Something went wrong');
    }
}
```

За запись пользователя в БД отвечает метод `register()`, которую нам нужно определить в нашей модели:

*app/models/User.php*

```php
// Register user
public function register($data){
    $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':password', $data['password']);

    if($this->db->execute()){
        return true;
    }
    else{
        return false;
    }
}
```

Здесь мы просто добавляем запись в базу данных и если запись успешно добавилась в БД, то мы возвращаем `true`, а если произошли какие-то сбои или ошибки, тогда `false`.

В файле будстрапа добавим вызов нашего хелпера:

*app/bootstrap.php*

```php
<?php

// Load Config
require_once "config/config.php";

// Load Helpers
require_once 'helpers/url_helper.php';

// Autoload Core Libraries
spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
});
```

В хелпере мы создадим собственную функцию `redirect()`, которая будет использовать функцию `header()` чтобы сделать редирект:

*app/helpers/url_helper.php*

```php
<?php

// Simple page redirect
function redirect($page){
    header('location: ' . URLROOT . $page);
}
```

## Хелпер для флеш сообщений

Нам нужно создать функцию, которая будет при первом вызове в контроллере записывать данные в сессию, а при повторном вызове в виде, при условии что передан только первый параметр выводить флеш сообщение и удалять сессионные переменные, чтобы при повторном загрузке этой же страницы сообщение у нас уже не отображалось:

*app/helpers/session_helper.php*

```php
<?php

// $_SESSION['user'] = 'Brad';
session_start();

// Flash message helper
// EXAMPLE - flash('register_success', 'You are now register', 'alert alert-danger');
// DISPLAY IN VIEW - echo flash('register_success')
function flash($name='', $message='', $class='alert alert-success'){
    if(!empty($name)){
        // Execute on the Controller
        if(!empty($message) && empty($_SESSION[$name])){
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        }
        // Execute on the View
        else if(empty($message) && !empty($_SESSION[$name])){
            echo '<div class="' . $_SESSION[$name . '_class'] . '">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}
```


Не забываем подключить этой хелпер в файле бутстрапа:

*app/bootstrap.php*

```php
// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
```

Теперь мы в контроллере вызываем этот метод с двумя или тремя (если хотим изменить стиль алерта) параметрами после записи в БД:

*app/controllers/Users.php*

```php
// Register users
if($this->userModel->register($data)){
    flash('register_success', 'You are registered and can log in');
    redirect('/users/login');
}
```

А в виде, куда мы редиректим пользователя, только с первым - это по сути ID сессионной переменной.

*app/views/users/login.php*

```php
<div class="card card-body bg-light mt-5">
    <?php flash('register_success') ?>
    <h2>Login</h2>
    <p>Please fill in your credentials to log in</p>
```