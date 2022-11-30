<?php

namespace StoreApp\Data;

use StoreApp\Data\Database;

ini_set('display_errors', 1);

class Order extends Database
{
    public function addOrder($item,$addressId)
    {
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id,address_id,order_date) 
            VALUES (:user_id,:address_id,:order_date)");
    
        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':user_id', $item['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':address_id', $addressId, \PDO::PARAM_INT);
        $stmt->bindParam(':order_date', $currentTime);
       
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $insertId = $this->conn->lastInsertId();
        if ($insertId) {
            $status = 1;
            $stmt = $this->conn->prepare("INSERT INTO order_details (order_id,product_id,order_quantity,status) 
            VALUES (:order_id,:product_id,:order_quantity,:status)");
    
            $currentTime = date("Y-m-d H:i:s");
            $stmt->bindParam(':order_id', $insertId, \PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $item['product_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':order_quantity', $item['quantity'], \PDO::PARAM_INT);
            $stmt->bindParam(':status', $status);
        
            try {
                $stmt->execute();
            } catch (\PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        } else {
            return false;
        }
        
    }

   
}