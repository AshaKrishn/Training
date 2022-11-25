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
            case 'login' : header("Location:http://$host$uri/home");
                exit;
            case 'logout' : header("Location:http://$host$uri/");
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
    
}