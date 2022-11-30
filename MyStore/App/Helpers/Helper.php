<?php

namespace StoreApp\Helpers;

class Helper
{
    public function setUserSession($input)
    {
        $_SESSION['userid'] = $input['id'];
        $_SESSION['username'] = $input['username'];
        return true;
    }
    public function unsetUserSession()
    {
        session_unset();
        session_destroy();
        return true;
    }

    public function redirect($status)
    {
        $host = $_SERVER['HTTP_HOST'];
        $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
        switch ($status) {
            case 'login' : header("Location:http://$host$uri/viewProducts");
                exit;
            case 'logout' : header("Location:http://$host$uri/");
                exit;
            case 'cart' : header("Location:http://$host$uri/viewCart");
                exit;
            case 'address' : header("Location:http://$host$uri/addAddressForm");
                exit;
            case 'profile' : header("Location:http://$host$uri/editProfile");
                exit;    
        }
        
    }

    public function validateUserInput($user) 
    {
        foreach ($user as $key=>$value) {
            if (!empty($value)) {
                $user[$key] = $this->sanitize($value);
                if ($key == 'phoneno') {
                    if(!$this->validatePhoneNo($value)) {
                        return false;  
                    }
                }
            } elseif (($key == 'firstname') || ($key == 'username') || ($key == 'password_1') || ($key == 'password_2') 
                        || ($key == 'phoneno') || ($key == 'email') || ($key == 'address') || ($key == 'state') 
                        || ($key == 'city') || ($key == 'country') || ($key == 'pincode')) {
                $this->printError($key);
                return false;
            }
        }
        if (isset($user['password_1'])) {
            if(!($user['password_1'] = $this->validatePassword($user['password_1'],$user['password_2']))) {
                return false;
            }
        }
        return $user;
    }

    public function validatePassword($password_1,$password_2)
    {
        if ($password_1 !== $password_2) {
            $this->printError('password_mismatch');
            return false;
        }
        return (password_hash($password_1, PASSWORD_DEFAULT));
    }

    public function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    public function validatePrice($price) 
    {
        if (!preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price)) {
            $this->printError('product_price_format');
            return false;
        }
        return true;
    }

    public function validatePhoneNo($phoneno)
    {
        if (!preg_match("/^[0-9]*$/", $phoneno)) {
            $this->printError('phone_not_number');
            return false;
        } elseif (strlen($phoneno)!=10) {
            $this->printError('phone_length_mismatch');
            return false;
        }
        return true;
    }

    public function printError($errMsg)
    {
        $error = new \StoreApp\Error\Error();
        return $error->errorMessage($errMsg);
    }
    
}