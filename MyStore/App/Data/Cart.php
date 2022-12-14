<?php

namespace StoreApp\Data;

use StoreApp\Data\Database;

ini_set('display_errors', 1);

class Cart extends Database
{
    public function add($product)
    {
        $stmt = $this->conn->prepare("INSERT INTO carts (
            user_id,product_id,quantity,created_on,modified_on) 
            VALUES (:user_id,:product_id,:quantity,:created_on,:modified_on) 
            ON DUPLICATE KEY UPDATE quantity=quantity+:quantity, modified_on=:modified_on");

        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':user_id', $product['userId'], \PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product['productId'], \PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $product['quantity'], \PDO::PARAM_INT);
        $stmt->bindParam(':created_on', $currentTime);
        $stmt->bindParam(':modified_on', $currentTime);
    
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $insertId = $this->conn->lastInsertId();
        if ($insertId) {
            return $insertId;
        } else {
            return false;
        }
   }

   public function get($userId,$cartId=null)
    {
        $str = '';
        if($cartId) {
            $str = " AND carts.id=:cart_id";
        }
        $stmt = $this->conn->prepare("SELECT user_id,product_id,name,make,price,currency,carts.id as cart_id,quantity FROM products 
                                INNER JOIN carts ON (products.id = carts.product_id) WHERE user_id = :user_id $str");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        if($cartId) {
            $stmt->bindParam(':cart_id', $cartId, \PDO::PARAM_INT);
        }
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        if ($cartId) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return $stmt->fetchAll();
   }

   public function delete($cartIDArray)
    {
        $inIds = ''; 
        $bindParams = array();
        foreach ($cartIDArray as $key=>$cartId) {
            $inIds .= ":id$key,";//:id1, :id2, :id3
            $bindParams[":id$key"] = $cartId;
        } 
        $inIds = rtrim($inIds,',');
        $stmt = $this->conn->prepare("DELETE FROM carts WHERE id IN ($inIds)");
        try {
            $stmt->execute($bindParams);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    


}
