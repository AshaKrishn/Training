<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Product;
use StoreApp\Data\Cart;
use StoreApp\Controllers\BaseController;
use StoreApp\Views\ProductForm;
use StoreApp\Views\CartView;

ini_set('display_errors', 1);

class ProductController extends BaseController
{
    public $product;
    public $cart;
    public $productForm;
    public $cartView;
    public function __construct()
    {
        parent::__construct();
        $this->product = new Product();
        $this->cart = new Cart();
        $this->productForm = new ProductForm();
        $this->cartView = new CartView();
    }
    public function validate()
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
