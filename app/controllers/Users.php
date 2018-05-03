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
}