<?php

namespace StoreApp\Controllers;

use StoreApp\Controllers\BaseController;
use StoreApp\Views\LoginForm;

ini_set('display_errors', 1);

class LoginController extends BaseController
{
    public $loginForm;
    public function __construct()
    {
        parent::__construct();
        $this->loginForm = new LoginForm();
    }
    public function validate()
    {
        if (empty($_POST)) {
            return $this->loginForm->display();
        }
        if (empty($_POST['username'])) {
            $this->helper->printError('username');
            return $this->loginForm->display();
        }
        $_POST['username'] = $this->helper->sanitize($_POST['username']);

        if (empty($_POST['password'])) {
            $this->helper->printError('password_1');
            return $this->loginForm->display();
        }
        $_POST['password'] = $this->helper->sanitize($_POST['password']);
        $this->login($_POST);
    }

    public function login($user)
    {
        if ($dbuser = $this->dbHelper->checkUsername($user['username'])) {
            if (password_verify($user['password'], $dbuser['password'])) {
                $this->helper->setUserSession($dbuser);
                $this->helper->redirect('login');
            } else {
                $this->helper->printError('incorrect_password');
                return $this->loginForm->display();
            }
        } else {
            $this->helper->printError('username_not_found');
            return $this->loginForm->display();
        }
    }

    public function logout()
    {
        if (!$this->helper->unsetUserSession()) {
            $this->helper->printError('logout');
        }
        $this->helper->redirect('logout');
    }
}
