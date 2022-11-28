<?php

namespace StoreApp\Helpers;

use StoreApp\Data\Database;

class DbHelper extends Database
{
    public function checkUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public function getUserAddresses($userId) 
    {
        $stmt = $this->conn->prepare("SELECT * FROM user_addresses WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
}