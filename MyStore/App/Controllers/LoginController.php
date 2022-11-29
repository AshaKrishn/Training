<?php

namespace StoreApp\Controllers;

use StoreApp\Helpers\DbHelper;
use StoreApp\Helpers\Helper;

ini_set('display_errors', 1);

class LoginController
{
    public function validateLogin()
    {
        if (empty($_POST)) {
            return $this->showLoginForm();
        }
        if (empty($_POST['username'])) {
            (new Helper())->printError('username');
            return $this->showLoginForm();
        }
        $_POST['username'] = (new Helper())->sanitize($_POST['username']);
      
        if (empty($_POST['password'])) {
            (new Helper())->printError('password_1');
            return $this->showLoginForm();
        } 
        $_POST['password'] = (new Helper())->sanitize($_POST['password']);
        $this->login($_POST);
    }

    public function login($user)
    {
        if ($dbuser = (new DbHelper())->checkUsername($user['username'])) {
            if (password_verify($user['password'], $dbuser['password'])) {
                (new Helper())->setUserSession($dbuser);
                (new Helper())->redirect('login');
            } else {
                (new Helper())->printError('incorrect_password');
                return $this->showLoginForm();
            }
        } else {
            (new Helper())->printError('username_not_found');
            return $this->showLoginForm();
        }
    }

    public function logout()
    {
        if(!(new Helper())->unsetUserSession()) {
            (new Helper())->printError('logout');
        }
        (new Helper())->redirect('logout');
    }

    public function showLoginForm()
    {
        $loginPage = new \StoreApp\Views\LoginForm();
        return $loginPage->display();
    }
}
