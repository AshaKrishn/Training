<?php

namespace StoreApp\Controllers;

use StoreApp\Helpers\Helper;
use StoreApp\Data\Order;
use StoreApp\Data\Product;
use StoreApp\Controllers\ProductController;
use StoreApp\Views\OrderView;

ini_set('display_errors', 1);

class OrderController
{
    public $helper;
    public $product;
    public $order;
    public $productController;
    public $orderView;

    public function __construct()
    {
        $this->helper = new Helper();
        $this->product = new Product();
        $this->order = new Order();
        $this->productController = new ProductController();
        $this->orderView = new OrderView();
    }
    public function add()
    {
        if (!$_POST) {
            return $this->productController->showCart();
        }
        foreach ($_POST['id'] as $cartId) {
            $items[] = $this->product->getUserCartItems($_SESSION['userid'],$cartId);
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
        $this->product->deleteCartItems($deleteCartIds);
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