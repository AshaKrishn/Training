<?php

session_start();
require 'vendor/autoload.php';
require 'route.php';

ini_set('display_errors', 1);

$route = new route();
if (isset($_SESSION['userid'])) {
    $route->add('index.php', 'StoreApp\Controllers\ProductController', 'showProducts');
    $route->add('logout', 'StoreApp\Controllers\LoginController', 'logout');
    $route->add('viewProducts', 'StoreApp\Controllers\ProductController', 'showProducts');
    $route->add('showAddresses', 'StoreApp\Controllers\ProductController', 'showAddresses');
    $route->add('manageCart', 'StoreApp\Controllers\ProductController', 'manageCart');
    $route->add('viewCart', 'StoreApp\Controllers\ProductController', 'showCart');
    $route->add('orderItems', 'StoreApp\Controllers\ProductController', 'showCart');
    $route->add('updateCart', 'StoreApp\Controllers\ProductController', 'updateCart');
    $route->add('placeOrder', 'StoreApp\Controllers\OrderController', 'placeOrder');
    $route->add('editProfile', 'StoreApp\Controllers\ProfileController', 'getProfile');
    $route->add('updateProfile', 'StoreApp\Controllers\ProfileController', 'updateProfile');
    $route->add('changePassword', 'StoreApp\Views\UserProfileForm', 'passwordChangeForm');
    $route->add('updatePassword', 'StoreApp\Controllers\ProfileController', 'updatePassword');
    $route->add('addAddressForm', 'StoreApp\Views\UserProfileForm', 'addAddressForm');
    $route->add('addAddress', 'StoreApp\Controllers\ProfileController', 'addAddress');
    $route->add('myOrders', 'StoreApp\Controllers\OrderController', 'viewOrders');
    $route->add('updateOrders', 'StoreApp\Controllers\OrderController', 'updateOrders');
    $route->add('manageOrders', 'StoreApp\Controllers\OrderController', 'manageOrders');
    $route->add('validateAddProduct', 'StoreApp\Controllers\ProductController', 'validateAddProduct');
    if ($_SESSION['username'] == 'admin') {
        $route->add('validateAddProduct', 'StoreApp\Controllers\ProductController', 'validateAddProduct');
        $route->add('manageProduct', 'StoreApp\Controllers\ProductController', 'manageProduct');
    }
} else {
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
}

include 'header.php';
$route->routeToThisUrl();
include 'footer.php';
