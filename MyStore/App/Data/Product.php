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

   public function get($id = null)
    {
        $str = '';
        $status = 1;
        if ($id) {
            $str  = " AND id=:id";
        }
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE status=:status $str");
        if($id) {
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        }
        $stmt->bindParam(':status', $status, \PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        if ($id) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return $stmt->fetchAll();
    }

    public function update($product,$status) 
    {
        $str = '';
        if ($status==0) {
            $str = "status=:status,modified_on=:modified_on";
        } else {
            $str = "description=:description,price=:price,currency=:currency,modified_on=:modified_on";
        }
        $stmt = $this->conn->prepare("UPDATE products SET $str WHERE id=:id");
        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':id', $product['id'], \PDO::PARAM_INT);
        $stmt->bindParam(':modified_on', $currentTime);
        if ($status==0) {
            $stmt->bindParam(':status', $status, \PDO::PARAM_INT);
        } else {
            $stmt->bindParam(':description', $product['description'], \PDO::PARAM_STR);
            $stmt->bindParam(':price', $product['price'], \PDO::PARAM_STR);
            $stmt->bindParam(':currency', $product['currency'], \PDO::PARAM_STR);
        }
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }
}
