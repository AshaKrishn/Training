<?php

namespace StoreApp\Data;

use StoreApp\Data\Database;

ini_set('display_errors', 1);

class Order extends Database
{
    public function addOrder($userId,$addressId)
    {
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id,address_id,order_date) 
                VALUES (:user_id,:address_id,:order_date)");

        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':address_id', $addressId, \PDO::PARAM_INT);
        $stmt->bindParam(':order_date', $currentTime);

        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $this->conn->lastInsertId();
    }

    public function addOrderDetails($orderId,$item)
    {
        $stmt = $this->conn->prepare("INSERT INTO order_details (order_id,product_id,order_quantity) 
        VALUES (:order_id,:product_id,:order_quantity)");

        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':order_id', $orderId, \PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $item['product_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':order_quantity', $item['quantity'], \PDO::PARAM_INT);
        
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }

    public function getUserOrders($userId,$orderStatus)
    {
       $stmt = $this->conn->prepare("SELECT orders.id as order_id,orders.user_id,address_id,order_date,address,city,state,country,postal_code
                                     from orders INNER JOIN user_addresses ON (orders.address_id = user_addresses.id) 
                                     WHERE orders.user_id=:user_id AND status=:status");                        
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':status', $orderStatus, \PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $stmt->fetchAll();
    }

    public function getUserOrderDetails($orderId) 
    {
        $stmt = $this->conn->prepare("SELECT order_details.id as order_details_id,order_id,product_id,
                                    order_quantity,shipping_date,order_details.status as status,name,make,price,currency,created_on
                                    FROM order_details INNER JOIN products ON (order_details.product_id = products.id)
                                    AND order_id=:order_id");
        
        $stmt->bindParam(':order_id', $orderId, \PDO::PARAM_INT);
        //$stmt->bindParam(':status', $orderStatus, \PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $stmt->fetchAll();
    }

    public function deleteOrderItems($orderItemId)
    {
        $stmt = $this->conn->prepare("DELETE FROM order_details WHERE id = :id AND status=:status");
        $status = 1;
        $stmt->bindParam(':id',$orderItemId, \PDO ::PARAM_INT);
        $stmt->bindParam(':status',$status, \PDO ::PARAM_INT);
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }

    public function getOrderDetails ($orderId) 
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders INNER JOIN order_details
                                        ON orders.id = order_details.order_id AND orders.id = :order_id;");

        $stmt->bindParam(':order_id', $orderId, \PDO::PARAM_INT);
        //$stmt->bindParam(':status', $orderStatus, \PDO::PARAM_INT);
        try {
        $stmt->execute();
        } catch (\PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
        }
        return $stmt->fetchAll();
    }

    public function deleteOrder($orderId) 
    {
        $stmt = $this->conn->prepare("UPDATE orders SET status=:status WHERE id=:id");
                        
        $currentTime = date("Y-m-d H:i:s");
        $status = 0;
        $stmt->bindParam(':id', $orderId, \PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }
   
}