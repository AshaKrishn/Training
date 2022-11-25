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
        $user = $_POST;
        if (empty($user)) {
            return $this->showRegistrationForm();
        }
        foreach ($user as $key=>$value) {
            if (!empty($value)) {
                $user[$key] = (new Helper())->sanitize($value);
                if ($key == 'phoneno') {
                    $this->validatePhoneNo($value);
                }
            } elseif (($key == 'firstname') || ($key == 'username') || ($key == 'password_1')
                        || ($key == 'password_2') || ($key == 'phoneno') || ($key == 'email')) {
                $this->printError($key);
                return $this->showRegistrationForm();
            }
        }
        if ($user['password_1'] !== $user['password_2']) {
            $this->printError('password_mismatch');
            return $this->showRegistrationForm();
        }
        $user['password_1'] = password_hash($user['password_1'], PASSWORD_DEFAULT);
        $this->register($user);
    }

    public function validatePhoneNo($phoneno)
    {
        if (!preg_match("/^[0-9]*$/", $phoneno)) {
            $this->printError('phone_not_number');
            return $this->showRegistrationForm();
        } elseif (strlen($phoneno)!=10) {
            $this->printError('phone_length_mismatch');
            return $this->showRegistrationForm();
        }
        return true;
    }

    public function register($user)
    {
        if ((new DbHelper())->checkUsername($user['username'])) {
            $this->printError('username_exists');
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

    public function printError($errMsg)
    {
        $error = new \StoreApp\Error\Error();
        return $error->errorMessage($errMsg);
    }

    public function showWelcomePage()
    {
        echo "<p><a href='index'><< Back to Home >></a></p>";
    }
}
