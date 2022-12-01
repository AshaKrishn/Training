<?php

namespace StoreApp\Controllers;

use StoreApp\Data\Order;
use StoreApp\Data\Product;
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
        foreach ($_POST['id'] as $cartId) {
            $items[] = (new Product)->getUserCartItems($_SESSION['userid'],$cartId);
        }
        if (!$items) {
            (new Helper())->printError('checkout');
            (new Helper())->redirect('cart');
        }
        $orderId = (new Order)->addOrder($_SESSION['userid'],$_POST['address']);
        if (!$orderId) {
            (new Helper())->printError('checkout');
            (new Helper())->redirect('cart');
        }
        foreach ($items as $item) {
            if((new Order)->addOrderDetails($orderId,$item)) {
               $deleteCartIds[] = $item['cart_id'];
            }
        }
        if (!$deleteCartIds) {
            (new Helper())->printError('checkout');
            (new Helper())->redirect('cart');  
        }
        (new Product())->deleteCartItems($deleteCartIds);
        (new Helper())->redirect('orders'); 
        
    }

    public function viewOrders()
    {
        $order = new Order();
        $orderLists = $order->getUserOrders($_SESSION['userid'],1); // Active orders
        foreach ($orderLists as $key=>$list) {
            $orderLists[$key]['products'] = $order->getUserOrderDetails($list['order_id']);
        }

        $orderView = new \StoreApp\Views\OrderView();
        return $orderView->display($orderLists);
    }

    public function manageOrders()
    {
        if (!$_POST) {
            $this->viewOrders();
        }
        if ((isset($_POST['action'])) && ($_POST['action']== 'productLists')) {
            $product = new Product();
            if ($productLists = $product->getProducts()) {
                return (new ProductController())->showProductForm('list', $productLists);
            }

        }
        if (isset($_POST['remove'])) {
            $order = new Order();
            if($order->deleteOrderItems($_POST['remove'])) {  
                if(!$order->getOrderDetails($_POST['order_id'])) {
                    $order->deleteOrder($_POST['order_id']);
                }
            }
        }
        (new Helper())->redirect('orders');

    }
  
}