<?php

namespace StoreApp\Views;

ini_set('display_errors', 1);
class Welcome 
{
    public function display()
    {
        echo "<html>";
            echo "<head>";
                echo "<title>My Store</title>";
            echo "</head>";
            echo "<body>";
                echo "<p>Welcome to My Store !!<p>";
                echo "<br><a href=\"login\"> Click here to login </br></a>";
                echo "<br><a href=\"register\"> Click here to register</br> </a>";
            echo "</body>";
        echo "</html>";
    }
}

