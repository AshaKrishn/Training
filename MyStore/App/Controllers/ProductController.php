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
        if (empty($_POST['name'])) {
            (new Helper())->printError('product_name');
            return $this->showProductForm('add');
        }
        $_POST['name'] = (new Helper())->sanitize($_POST['name']);
        if (empty($_POST['make'])) {
            (new Helper())->printError('product_make');
            return $this->showProductForm('add');
        }
        $_POST['make'] = (new Helper())->sanitize($_POST['make']);
        if (empty($_POST['price'])) {
            (new Helper())->printError('product_price');
            return $this->showProductForm('add');
        }
        $_POST['price'] = (new Helper())->sanitize($_POST['price']);
        if (!(new Helper())->validatePrice($_POST['price'])) {
            $this->showProductForm('add');
        }
        $this->addProduct($_POST);
    }

    public function addProduct($product)
    {
        $newProduct = new Product();
        if ($product['id'] = $newProduct->add($product)) {
            echo "Successfully added the product..!";
            (new Helper())->redirect('products');
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

    public function updateCart()
    {
        $items = array();
        $cartIds = array();

        if (!$_POST || $_POST['action'] == 'productLists') {
            $product = new Product();
            if ($productLists = $product->getProducts()) {
                return $this->showProductForm('list', $productLists);
            }
        }

        //revisit this code
        foreach ($_POST as $value) {
            if (isset($value['id'])) {
                $items[] = $value;
                $cartIds[] = $value['id'] ;
            }
        }
        if (empty($items)) {
            (new Helper())->printError('no_item_selected');
            return $this->showCart();
        }
        if ($_POST['action'] == 'buy') {
            $userAddresses = (new DbHelper())->getUserAddresses($_SESSION['userid']);
            $cartView = new \StoreApp\Views\CartView();
            return $cartView->viewShippingAddresses($items, $userAddresses);
        }
        // remove items from cart
        $product = new Product();
        $product->deleteCartItems($cartIds);
        (new Helper())->redirect('cart');
    }

    public function manageCart()
    {
        if (isset($_POST['productId'])) {
            $order['productId'] = $_POST['productId'];
            $order['quantity'] = $_POST['quantity'][$order['productId']];
            $order['userId'] = $_SESSION['userid'];
            $product = new Product();
            if ($product->addProductToCart($order)) {
                echo "Successfully added the product..!";
                (new Helper())->redirect('cart');
            } else {
                (new Helper())->printError('cart_add_error');
                return $this->showProductForm('lists');
            }
        }
        if (isset($_POST['editId'])) {
            $productValue = (new Product())->getProducts($_POST['editId']);
            return $this->showProductForm('edit', $productValue);
        }
        (new Helper())->redirect('products');
    }

    public function manageProduct()
    {
        $status = 1;
        if (!isset($_POST)) {
            (new Helper())->redirect('products');
        }
        if ($_POST['action'] == 'delete') {
            $status = 0;
        }
        (new Product())->updateProduct($_POST,$status);
        (new Helper())->redirect('products');
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
        } elseif ($type == 'list') {
            return $page->viewProducts($value);
        } elseif ($type == 'edit') {
            return $page->editProduct($value);
        }
        return false;
    }
}
