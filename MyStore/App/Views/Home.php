<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class Home 
{
    public function display()
    {
        echo "welcome ".$_SESSION['username'];
        return;
    }
}

