<?php
namespace StoreApp\Controllers;

require_once $_SERVER['DOCUMENT_ROOT']."/git_repo/Training/MyStore/vendor/autoload.php";
use StoreApp\Data\Registration;
ini_set('display_errors', 1);


class Register {
    function validateRegistration($user) {
        foreach ($user as $key=>$value) {
            if (!empty($value)) {
                $user[$key] = sanitize($value);
            } else {
                if ($key == 'firstname' || 'username' || 'password_1' || 'password_2' || 'phoneno') {
                    errorMessage($key);
                }
                return;
            }
        }

        if ($user['password_1'] !== $user['password_2']) {
            errorMessage('password_mismatch');
            return;
        }

        $newRegistration = new Registration();
        $newRegistration->registerUser($user);
       
    }
    function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;    
    }

    function errorMessage($errMsg)
    {
    switch ($errMsg){
        case 'firstname' : echo "First name cannot be empty";
        case 'username' : echo "User name cannot be empty";
        case 'password_1' : echo "Password cannot be empty";
        case 'password_2' : echo "Confirm password cannot be empty";
        case 'phoneno' : echo "Confirm password cannot be empty";
        case 'password_mismatch' : echo "Confirm password is not matching with the password entered";

    }
    }
}