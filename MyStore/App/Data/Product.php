<?php

namespace StoreApp\Data;

use StoreApp\Data\Database;

ini_set('display_errors', 1);

class Product extends Database
{
    public function add($product)
    {
        $stmt = $this->conn->prepare("INSERT INTO products (
            name,make,description,price,currency,created_on,modified_on) 
            VALUES (:name,:make,:description,:price,:currency,:created_on,:modified_on)");

        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':name', $product['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':make', $product['make'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $product['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':price', $product['price'], \PDO::PARAM_STR);
        $stmt->bindParam(':currency', $product['currency'], \PDO::PARAM_STR);
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

   public function getProducts()
    {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $stmt->fetchAll();
   }

   public function addProductToCart($product)
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

   public function getUserCartItems($userId)
    {
        $stmt = $this->conn->prepare("SELECT product_id,name,make,price,currency,carts.id as cart_id,quantity FROM products 
                                INNER JOIN carts ON (products.id = carts.product_id) WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $stmt->fetchAll();
   }


}
