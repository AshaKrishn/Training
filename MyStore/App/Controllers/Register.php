<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Registration;


ini_set('display_errors', 1);

class Register
{
    public function validateRegistration()
    {
        $user = $_POST;
        if (!empty($user)) {
            foreach ($user as $key=>$value) {
                if (!empty($value)) {
                    $user[$key] = $this->sanitize($value);
                    if ($key == 'phoneno') {
                        $this->validatePhoneNo($value);
                    }
                } elseif ($key == 'firstname' || 'username' || 'password_1' || 'password_2' || 'phoneno' || 'email') {
                    $this->errorMessage($key);
                    $this->showRegistrationForm();
                    die();
                }
            }

            if ($user['password_1'] !== $user['password_2']) {
                $this->errorMessage('password_mismatch');
                $this->showRegistrationForm();
                die();
            }
            $this->register($user);
        } else {
            $this->showRegistrationForm();
        }
    }
    public function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    public function validatePhoneNo($phoneno)
    {
        if (!preg_match("/^[0-9]*$/", $phoneno)) {
            $this->errorMessage('phone_not_number');
            $this->showRegistrationForm();
            die();
        } elseif (strlen($phoneno)!=10) {
            $this->errorMessage('phone_length_mismatch');
            $this->showRegistrationForm();
            die();
        }
        return true;
    }

    public function register($user)
    {
        $newRegistration = new Registration();
        if ($newRegistration->checkUsername($user['username'])) {
            $this->errorMessage('username_exists');
            $this->showRegistrationForm();
            die();
        } 
        if ($newRegistration->registerUser($user)) {
            echo "Successfully Registered";
            //$this->showHomePage();
        } else {
            echo "Error while Registering";
            $this->showRegistrationForm();
            die();
        }
    }

    public function showRegistrationForm()
    {
        $regPage = new \StoreApp\Views\RegistrationForm;
        $regPage->display();
    }
    public function errorMessage($errMsg)
    {
        switch ($errMsg) {
            case 'firstname': echo "<br>First name cannot be empty..!!</br>"; break;
            case 'username': echo "<br>User name cannot be empty..!!</br>";break;
            case 'password_1': echo "<br>Password cannot be empty..!!</br>";break;
            case 'password_2': echo "<br>Confirm password cannot be empty..!!</br>";break;
            case 'phoneno': echo "<br>Phone number cannot be empty..!!</br>";break;
            case 'email': echo "<br>Email required..!!</br>";break;
            case 'password_mismatch': echo "<br>Confirm password is not matching with the password entered..!!</br>";break;
            case 'phone_not_number': echo "<br>Please enter only numeric value for phone number..!!</br>";break;
            case 'phone_length_mismatch': echo "<br>The length of phone number must be 10 digits..!!</br>";break;
            case 'username_exists': echo "<br>This username exists.Please choose a different one..!!</br>";break;
        }
    }
}
