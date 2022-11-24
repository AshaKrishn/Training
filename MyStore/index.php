<?php

require 'vendor/autoload.php';
require 'route.php';
ini_set('display_errors', 1);

$route = new route();

$route->add('/', 'StoreApp\Views\Welcome', 'display');
$route->add('App/', 'StoreApp\Views\Welcome', 'display');
$route->add('index.php', 'StoreApp\Views\Welcome', 'display');
$route->add('index', 'StoreApp\Views\Welcome', 'display');
$route->add('App/register', 'StoreApp\Views\RegistrationForm', 'display');
$route->add('register', 'StoreApp\Views\RegistrationForm', 'display');
$route->add('error', 'StoreApp\Error', 'pageNotFound');
$route->add('validateRegistration', 'StoreApp\Controllers\RegisterController', 'validateRegistration');
$route->add('login', 'StoreApp\Views\LoginForm', 'display');
$route->add('validateLogin', 'StoreApp\Controllers\LoginController', 'validateLogin');
$route->add('home', 'StoreApp\Views\Home', 'display');

$route->routeToThisUrl();
