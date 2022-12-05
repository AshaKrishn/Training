<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Product;
use StoreApp\Helpers\DbHelper;
use StoreApp\Helpers\Helper;
use StoreApp\Views\ProductForm;
use StoreApp\Views\CartView;

ini_set('display_errors', 1);

class ProductController
{
    public $helper;
    public $dbHelper;
    public $product;
    public $productForm;
    public $cartView;
    public function __construct()
    {
        $this->helper = new Helper();
        $this->dbHelper = new DbHelper();
        $this->product = new Product();
        $this->productForm = new ProductForm();
        $this->cartView = new CartView();
    }
    public function validateAddProduct()
    {
        if (empty($_POST)) {
            return $this->showProductForm('add');
        }
        if (empty($_POST['name'])) {
            $this->helper->printError('product_name');
            return $this->showProductForm('add');
        }
        $_POST['name'] = $this->helper->sanitize($_POST['name']);
        if (empty($_POST['make'])) {
            $this->helper->printError('product_make');
            return $this->showProductForm('add');
        }
        $_POST['make'] = $this->helper->sanitize($_POST['make']);
        if (empty($_POST['price'])) {
            $this->helper->printError('product_price');
            return $this->showProductForm('add');
        }
        $_POST['price'] = $this->helper->sanitize($_POST['price']);
        if (!$this->helper->validatePrice($_POST['price'])) {
            $this->showProductForm('add');
        }
        $this->add($_POST);
    }

    public function add($product)
    {
       if ($product['id'] = $this->product->add($product)) {
            echo "Successfully added the product..!";
            $this->helper->redirect('products');
        } else {
            echo "Error while adding";
            return $this->showProductForm('add');
        }
    }

    public function show()
    {
        $productLists = $this->product->get();
        return $this->showProductForm('list', $productLists);
    }

    public function update()
    {
        $status = 1;
        if (!isset($_POST)) {
            $this->helper->redirect('products');
        }
        if ($_POST['action'] == 'delete') {
            $status = 0;
        }
        $this->product->update($_POST,$status);
        $this->helper->redirect('products');
    }

    public function updateCart()
    {
        $items = array();
        $cartIds = array();

        if (!$_POST || $_POST['action'] == 'productLists') {
            if ($productLists = $this->product->get()) {
                return $this->showProductForm('list', $productLists);
            }
        }

        foreach ($_POST as $value) {
            if (isset($value['id'])) {
                $items[] = $value;
                $cartIds[] = $value['id'] ;
            }
        }
        if (empty($items)) {
            $this->helper->printError('no_item_selected');
            return $this->showCart();
        }
        if ($_POST['action'] == 'buy') {
            $userAddresses = $this->dbHelper->getUserAddresses($_SESSION['userid']);
            return $this->cartView->viewShippingAddresses($items, $userAddresses);
        }
        // remove items from cart
        $this->product->deleteCartItems($cartIds);
        $this->helper->redirect('cart');
    }

    public function manageCart()
    {
        if (isset($_POST['productId'])) {
            $order['productId'] = $_POST['productId'];
            $order['quantity'] = $_POST['quantity'][$order['productId']];
            $order['userId'] = $_SESSION['userid'];
            if ($this->product->addProductToCart($order)) {
                echo "Successfully added the product..!";
                $this->helper->redirect('cart');
            } else {
                $this->helper->printError('cart_add_error');
                return $this->showProductForm('lists');
            }
        }
        if (isset($_POST['editId'])) {
            $productValue = $this->product->get($_POST['editId']);
            return $this->showProductForm('edit', $productValue);
        }
        $this->helper->redirect('products');
    }

    public function showCart()
    {
        $cartItems = $this->product->getUserCartItems($_SESSION['userid']);
        return $this->cartView->display($cartItems);
    }

    public function showProductForm($type, $value = null)
    {
        if ($type == 'add') {
            return $this->productForm->add();
        } elseif ($type == 'list') {
            return $this->productForm->view($value);
        } elseif ($type == 'edit') {
            return $this->productForm->edit($value);
        }
        return false;
    }
}
