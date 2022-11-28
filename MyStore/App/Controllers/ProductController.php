<?php

namespace StoreApp\Controllers;


use StoreApp\Data\Product;
use StoreApp\Helpers\DbHelper;
use StoreApp\Helpers\Helper;

ini_set('display_errors', 1);

class ProductController
{
    public function validateAddProduct()
    {
        if (empty($_POST)) {
            return $this->showProductForm('add');
        }
        if (!empty($_POST['name'])) {
            $_POST['name'] = (new Helper())->sanitize($_POST['name']);
        } else {
            $this->printError('product_name');
            return $this->showProductForm('add');
        }
        if (!empty($_POST['make'])) {
            $_POST['make'] = (new Helper())->sanitize($_POST['make']);
        } else {
            $this->printError('product_make');
            return $this->showProductForm('add');
        }
        if (!empty($_POST['price'])) {
            $_POST['price'] = (new Helper())->sanitize($_POST['price']);
            $this->validatePrice($_POST['price']);
        } else {
            $this->printError('product_price');
            return $this->showProductForm('add');
        }
        $this->addProduct($_POST);
    }

    public function addProduct($product) 
    {
        $newProduct = new Product();
        if ($product['id'] = $newProduct->add($product)) {
            echo "Successfully added the product..!";
            $this->showProducts();
        } else {
            echo "Error while adding";
            return $this->showProductForm('add');
        } 
    }

    public function showProducts()
    {
        $product = new Product();
        $productLists = $product->getProducts();
        return $this->showProductForm('list', $productLists);
    }

    public function showAddresses()
    {
        if (!$_POST) {
            $product = new Product();
            if ($productLists = $product->getProducts()) {
                return $this->showProductForm('list', $productLists);
            }
        }
        $userAddresses = (new DbHelper())->getUserAddresses($_SESSION['userid']);
        if (!$userAddresses) {
            $this->printError('no_address_found');
            return false;
        }
        foreach ($userAddresses as $key=>$address) {
            echo "<pre>";
            print_r($address);

        }
        die();
    }

    public function addToCart()
    {
        $order['productId'] = $_POST['productId'];
        $order['quantity'] = $_POST['quantity'][$order['productId']];
        $order['userId'] = $_SESSION['userid'];
        $product = new Product();
        if ($product->addProductToCart($order)) {
            echo "Successfully added the product..!";
            //return $this->showCart();
            (new Helper())->redirect('cart');
        } else {
            $this->printError('cart_add_error');
            return $this->showProductForm('lists');
        }
    }

    public function validatePrice($price) {
        if (!preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price)) {
            $this->printError('product_price_format');
            return $this->showProductForm('add');
        }
        return true;
    }
    
    public function showCart()
    {
        $product = new Product();
        $cartItems = $product->getUserCartItems($_SESSION['userid']);
        
        $cartView = new \StoreApp\Views\CartView();
        return $cartView->display($cartItems);
        
    }

    public function showProductForm($type, $value = null)
    {
        $page = new \StoreApp\Views\ProductForm();
        if ($type == 'add') {
            return $page->addProduct();
        } else if ($type == 'list') {
            return $page->viewProducts($value);
        }
        return false;
    }

    public function printError($errMsg)
    {
        $error = new \StoreApp\Error\Error();
        return $error->errorMessage($errMsg);
    }
}
