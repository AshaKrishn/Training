<?php
namespace StoreApp\Controllers;

use StoreApp\Data\Registration;

ini_set('display_errors', 1);

class Register 
{
    public function validateRegistration() {
        $user = $_POST;
        if (!empty($user)) {
            foreach ($user as $key=>$value) {
                if (!empty($value)) {
                    $user[$key] = $this->sanitize($value);
                    if ($key == 'phoneno') {
                        if (!preg_match("/^[0-9]*$/", $value)) {
                            $this->errorMessage('phone_not_number');
                        } elseif (strlen($value)!=10) {
                            $this->errorMessage('phone_length_mismatch');
                            return false;
                        }
                    }
                } else {
                    if ($key == 'firstname' || 'username' || 'password_1' || 'password_2' || 'phoneno' || 'email') {
                        $this->errorMessage($key);
                        return false;
                    }
                }
            }

            if ($user['password_1'] !== $user['password_2']) {
                $this->errorMessage('password_mismatch');
                return false;
            }

            $newRegistration = new Registration();
            if ($newRegistration->checkUsername($user['username'])) {
                $this->errorMessage('username_exists');
                return;
            } else {
                echo "new user";
            }

            $newRegistration->registerUser($user);
            return true;
        } else {
            echo "No Input";
        }
       
    }
    public function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;    
    }

    public function errorMessage($errMsg)
    {
        switch ($errMsg){
            case 'firstname' : echo "<br>First name cannot be empty..!!</br>";
            case 'username' : echo "<br>User name cannot be empty..!!</br>";
            case 'password_1' : echo "<br>Password cannot be empty..!!</br>";
            case 'password_2' : echo "<br>Confirm password cannot be empty..!!</br>";
            case 'phoneno' : echo "<br>Phone number cannot be empty..!!</br>";
            case 'email' : echo "<br>Email required..!!</br>";
            case 'password_mismatch' : echo "<br>Confirm password is not matching with the password entered..!!</br>";
            case 'phone_not_number' : echo "<br>Please enter only numeric value for phone number..!!</br>";
            case 'phone_length_mismatch' : echo "<br>The length of phone number must be 10 digits..!!</br>";
            case 'username_exists' : echo "<br>This username exists.Please choose a different one..!!</br>";
            
        }
    }
}