<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Registration;
use StoreApp\Helpers\DbHelper;
use StoreApp\Helpers\Helper;
ini_set('display_errors', 1);

class RegisterController
{
    public function validateRegistration()
    {
        if (empty($_POST)) {
            return $this->showRegistrationForm();
        }
        if(!$user = (new Helper())->validateUserInput($_POST)) {
            return $this->showRegistrationForm();
        }
        $this->register($user);
    }

    public function register($user)
    {
        if ((new DbHelper())->checkUsername($user['username'])) {
            (new Helper())->printError('username_exists');
            return $this->showRegistrationForm();
        }
        $newRegistration = new Registration();
        if ($user['id'] = $newRegistration->registerUser($user)) {
            echo "Successfully registered..!";
            (new Helper())->setUserSession($user);
            (new Helper())->redirect('login');
        } else {
            echo "Error while Registering";
            return $this->showRegistrationForm();
        }
    }

    public function showRegistrationForm()
    {
        $page = new \StoreApp\Views\RegistrationForm();
        return $page->display();
    }

    public function showHomePage()
    {
        $page = new \StoreApp\Views\Home();
        return $page->display();
    }
    public function showWelcomePage()
    {
        echo "<p><a href='index'><< Back to Home >></a></p>";
    }
}
