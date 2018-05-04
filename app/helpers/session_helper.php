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