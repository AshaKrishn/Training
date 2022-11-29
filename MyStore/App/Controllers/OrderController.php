<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Order;
use StoreApp\Controllers\ProductController;
use StoreApp\Helpers\DbHelper;
use StoreApp\Helpers\Helper;

ini_set('display_errors', 1);

class OrderController
{
    public function placeOrder()
    {
        
        if (!$_POST) {
            $product = new ProductController();
            return $product->showCart();
        }
        /*
        echo "<pre>";
        print_r($_POST);
        foreach ($_POST['id'] as $cartId) {

        }
        */

    }
}