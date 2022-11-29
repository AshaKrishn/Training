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
        }
        
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

    public function printError($errMsg)
    {
        $error = new \StoreApp\Error\Error();
        return $error->errorMessage($errMsg);
    }
    
}