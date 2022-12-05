<?php

namespace StoreApp\Controllers;

use StoreApp\Controllers\BaseController;
use StoreApp\Data\Cart;
use StoreApp\Data\Product;
use StoreApp\Views\CartView;
use StoreApp\Views\ProductForm;


ini_set('display_errors', 1);

class CartController extends BaseController
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
    public function update()
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
            return $this->show();
        }
        if ($_POST['action'] == 'buy') {
            $userAddresses = $this->dbHelper->getUserAddresses($_SESSION['userid']);
            return $this->cartView->viewShippingAddresses($items, $userAddresses);
        }
        // remove items from cart
        $this->cart->delete($cartIds);
        $this->helper->redirect('cart');
    }

    public function manageCart()
    {
        if (isset($_POST['productId'])) { 
            $order['productId'] = $_POST['productId'];
            $order['quantity'] = $_POST['quantity'][$order['productId']];
            $order['userId'] = $_SESSION['userid'];
            if ($this->cart->add($order)) {
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

    public function show()
    {
        $cartItems = $this->cart->get($_SESSION['userid']);
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
