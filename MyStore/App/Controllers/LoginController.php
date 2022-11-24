<?php

namespace StoreApp\Controllers;

use StoreApp\Helpers\StringHelper;
use StoreApp\Helpers\DbHelper;

ini_set('display_errors', 1);

class LoginController
{
    public function validateLogin() 
    {
        if (empty($_POST)) {
            return $this->showLoginForm();
        }
        if (!empty($_POST['username'])) {
           $_POST['username'] = (new StringHelper())->sanitize($_POST['username']);
        } else {
            $this->printError('username');
            return $this->showLoginForm();
        }
        if (!empty($_POST['password'])) {
            $_POST['password'] = (new StringHelper())->sanitize($_POST['password']);
        } else { 
            $this->printError('password_1');
            return $this->showLoginForm();
        }
        $this->login($_POST);

    }

    public function login($user)
    {
        if ($result = (new DbHelper)->checkUsername($user['username'])) {
           if (password_verify($user['password'],$result['password'])) {
                $_SESSION['userid'] = $result['id'];
                $_SESSION['username'] = $result['username'];
                $homePage = new \StoreApp\Views\Home();
                return $homePage->display();
            } else {
                $this->printError('incorrect_password');
                return $this->showLoginForm();
            }
        } else {
            $this->printError('username_not_found');
            return $this->showLoginForm();
        }
        
    }
    
    public function showLoginForm()
    {
        $loginPage = new \StoreApp\Views\LoginForm();
        return $loginPage->display();
    }
    public function printError($errMsg)
    {
        $error = new \StoreApp\Error\Error();
        return $error->errorMessage($errMsg);
    }
}
