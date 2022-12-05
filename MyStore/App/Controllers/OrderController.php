<?php

namespace StoreApp\Controllers;

use StoreApp\Controllers\BaseController;
use StoreApp\Controllers\CartController;
use StoreApp\Controllers\ProductController;
use StoreApp\Data\Cart;
use StoreApp\Data\Order;
use StoreApp\Data\Product;
use StoreApp\Views\OrderView;

ini_set('display_errors', 1);

class OrderController extends BaseController
{
    public $product;
    public $order;
    public $cart;
    public $productController;
    public $cartController;
    public $orderView;

    public function __construct()
    {
        parent::__construct();
        $this->order = new Order();
        $this->cart = new Cart();
        $this->product = new Product();
        $this->productController = new ProductController();
        $this->cartController = new CartController();
        $this->orderView = new OrderView();
    }
    public function add()
    {
        if (!$_POST) {
            return $this->cartController->show();
        }
        foreach ($_POST['id'] as $cartId) {
            $items[] = $this->cart->get($_SESSION['userid'],$cartId);
        }
        if (!$items) {
            $this->helper->printError('checkout');
            $this->helper->redirect('cart');
        }
        $orderId = $this->order->addOrder($_SESSION['userid'],$_POST['address']);
        if (!$orderId) {
            $this->helper->printError('checkout');
            $this->helper->redirect('cart');
        }
        foreach ($items as $item) {
            if($this->order->addOrderDetails($orderId,$item)) {
               $deleteCartIds[] = $item['cart_id'];
            }
        }
        if (!$deleteCartIds) {
            $this->helper->printError('checkout');
            $this->helper->redirect('cart');  
        }
        $this->cart->delete($deleteCartIds);
        $this->helper->redirect('orders'); 
        
    }

    public function view()
    {
        $orderLists = $this->order->getUserOrders($_SESSION['userid'],1); // Active orders
        foreach ($orderLists as $key=>$list) {
            $orderLists[$key]['products'] = $this->order->getUserOrderDetails($list['order_id']);
        }
        return $this->orderView->display($orderLists);
    }

    public function manageOrders()
    {
        if (!$_POST) {
            $this->view();
        }
        if ((isset($_POST['action'])) && ($_POST['action']== 'productLists')) {
            if ($productLists = $this->product->get()) {
                return $this->productController->showProductForm('list', $productLists);
            }

        }
        if (isset($_POST['remove'])) {
            if($this->order->deleteOrderItems($_POST['remove'])) {  
                if(!$this->order->getOrderDetails($_POST['order_id'])) {
                    $this->order->deleteOrder($_POST['order_id']);
                }
            }
        }
        $this->helper->redirect('orders');

    }
  
}