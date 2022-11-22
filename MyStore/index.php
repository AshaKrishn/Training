<?php
require 'vendor/autoload.php';
require 'route.php';
ini_set('display_errors', 1);

//$welcomePage = new StoreApp\Views\Welcome();
//$welcomePage->display();

$route = new route();

$route->add('/','StoreApp\Views\Welcome','display');
$route->add('App/','StoreApp\Views\Welcome','display');
$route->add('index.php','StoreApp\Views\Welcome','display');
$route->add('App/register','StoreApp\RegistrationForm','display');
$route->add('register','StoreApp\RegistrationForm','display');
//$route->add('login','StoreApp\login.php');
$route->add('validateRegistration','StoreApp\Controllers\Register','validateRegistration');
//echo "<pre>";
//print_r($route);

$route->checkMatch();