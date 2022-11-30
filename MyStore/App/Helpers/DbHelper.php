<?php

namespace StoreApp\Helpers;

use StoreApp\Data\Database;

class DbHelper extends Database
{
    public function checkUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserAddresses($userId) 
    {
        $deleted = 'no';
        $stmt = $this->conn->prepare("SELECT * FROM user_addresses WHERE user_id = :user_id AND deleted = :deleted");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':deleted', $deleted, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserDetails($userId) 
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    
    
}