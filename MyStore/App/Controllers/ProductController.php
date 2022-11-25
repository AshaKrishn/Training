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
            return $this->showProductForm();
        }
        if (!empty($_POST['name'])) {
            $_POST['name'] = (new Helper())->sanitize($_POST['name']);
        } else {
            $this->printError('product_name');
            return $this->showProductForm();
        }
        if (!empty($_POST['make'])) {
            $_POST['make'] = (new Helper())->sanitize($_POST['make']);
        } else {
            $this->printError('product_make');
            return $this->showProductForm();
        }
        if (!empty($_POST['price'])) {
            $_POST['price'] = (new Helper())->sanitize($_POST['price']);
            $this->validatePrice($_POST['price']);
        } else {
            $this->printError('product_price');
            return $this->showProductForm();
        }
        $this->addProduct($_POST);
    }

    public function addProduct($product) 
    {
        $newProduct = new Product();
        if ($product['id'] = $newProduct->add($product)) {
            echo "Successfully added the product..!";
            $homePage = new \StoreApp\Views\Home();
            return $homePage->display();
        } else {
            echo "Error while adding";
            return $this->showProductForm();
        } 
    }
    public function validatePrice($price) {
        if (!preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price)) {
            $this->printError('product_price_format');
            return $this->showProductForm();
        }
        return true;
    }
    
    public function showProductForm()
    {
        $page = new \StoreApp\Views\ProductForm();
        return $page->addProduct();
    }
    public function printError($errMsg)
    {
        $error = new \StoreApp\Error\Error();
        return $error->errorMessage($errMsg);
    }
}
