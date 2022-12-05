<?php

session_start();
require 'vendor/autoload.php';
require 'route.php';
define('ERROR_MSG_FILE', 'App/Error/Error.json');
ini_set('display_errors', 1);


$route = new route();
if (isset($_SESSION['userid'])) {
    $route->add('index.php', 'StoreApp\Controllers\ProductController', 'show');
    $route->add('logout', 'StoreApp\Controllers\LoginController', 'logout');
    $route->add('viewProducts', 'StoreApp\Controllers\ProductController', 'show');
    $route->add('showAddresses', 'StoreApp\Controllers\ProductController', 'showAddresses');
    $route->add('manageCart', 'StoreApp\Controllers\CartController', 'manageCart');
    $route->add('viewCart', 'StoreApp\Controllers\CartController', 'show');
    $route->add('orderItems', 'StoreApp\Controllers\CartController', 'show');
    $route->add('updateCart', 'StoreApp\Controllers\CartController', 'update');
    $route->add('placeOrder', 'StoreApp\Controllers\OrderController', 'add');
    $route->add('editProfile', 'StoreApp\Controllers\ProfileController', 'get');
    $route->add('updateProfile', 'StoreApp\Controllers\ProfileController', 'update');
    $route->add('changePassword', 'StoreApp\Views\UserProfileForm', 'passwordChangeForm');
    $route->add('updatePassword', 'StoreApp\Controllers\ProfileController', 'updatePassword');
    $route->add('addAddressForm', 'StoreApp\Views\UserProfileForm', 'addAddressForm');
    $route->add('addAddress', 'StoreApp\Controllers\ProfileController', 'addAddress');
    $route->add('myOrders', 'StoreApp\Controllers\OrderController', 'view');
    $route->add('updateOrders', 'StoreApp\Controllers\OrderController', 'updateOrders');
    $route->add('manageOrders', 'StoreApp\Controllers\OrderController', 'manageOrders');
    $route->add('validateAddProduct', 'StoreApp\Controllers\ProductController', 'validate');
    if ($_SESSION['username'] == 'admin') {
        $route->add('validateAddProduct', 'StoreApp\Controllers\ProductController', 'validate');
        $route->add('manageProduct', 'StoreApp\Controllers\ProductController', 'update');
    }
} else {
    $route->add('/', 'StoreApp\Views\Welcome', 'display');
    $route->add('App/', 'StoreApp\Views\Welcome', 'display');
    $route->add('index.php', 'StoreApp\Views\Welcome', 'display');
    $route->add('index', 'StoreApp\Views\Welcome', 'display');
    $route->add('App/register', 'StoreApp\Views\RegistrationForm', 'display');
    $route->add('register', 'StoreApp\Views\RegistrationForm', 'display');
    $route->add('error', 'StoreApp\Error', 'pageNotFound');
    $route->add('validateRegistration', 'StoreApp\Controllers\RegisterController', 'validate');
    $route->add('login', 'StoreApp\Views\LoginForm', 'display');
    $route->add('validateLogin', 'StoreApp\Controllers\LoginController', 'validate');
}

include 'header.php';
$route->routeToThisUrl();
include 'footer.php';
