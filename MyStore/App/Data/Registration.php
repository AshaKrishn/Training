<?php

namespace StoreApp\Data;

use StoreApp\Data\Database;

ini_set('display_errors', 1);

class Registration extends Database
{
    public function registerUser($newUser)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (
                                first_name,last_name,username,password,phone_no,gender,email,created_on,modified_on,is_logged) 
                                VALUES (:firstname,:lastname,:username,:password,:phoneno,:gender,:email,:created,:modified,:islogged)");

        $currentTime = date("Y-m-d H:i:s");
        $isLoggedStatus = 1;

        $stmt->bindParam(':firstname', $newUser['firstname'], \PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $newUser['lastname'], \PDO::PARAM_STR);
        $stmt->bindParam(':username', $newUser['username'], \PDO::PARAM_STR);
        $stmt->bindParam(':password', $newUser['password_1'], \PDO::PARAM_STR);
        $stmt->bindParam(':phoneno', $newUser['phoneno'], \PDO::PARAM_INT);
        $stmt->bindParam(':gender', $newUser['gender'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $newUser['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':created', $currentTime);
        $stmt->bindParam(':modified', $currentTime);
        $stmt->bindParam(':islogged', $isLoggedStatus, \PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        $insertId = $this->conn->lastInsertId();
        if ($insertId) {
            $this->registerUserAddresses($insertId, $newUser);
            return $insertId;
        } else {
            return false;
        }
    }

    public function registerUserAddresses($id, $user)
    {
        $currentTime = date("Y-m-d H:i:s");
        $stmt = $this->conn->prepare("INSERT INTO user_addresses (
            user_id,address,postal_code,city,state,country,address_type,default_address,created_on,modified_on) 
            VALUES (:user_id,:address,:postal_code,:city,:state,:country,:address_type,:default_address,:created_on,:modified_on)");

        $stmt->bindParam(':user_id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':address', $user['address'], \PDO::PARAM_STR);
        $stmt->bindParam(':postal_code', $user['pincode'], \PDO::PARAM_STR);
        $stmt->bindParam(':city', $user['city'], \PDO::PARAM_STR);
        $stmt->bindParam(':state', $user['state'], \PDO::PARAM_STR);
        $stmt->bindParam(':country', $user['country'], \PDO::PARAM_STR);
        $stmt->bindParam(':address_type', $user['address_type'], \PDO::PARAM_STR);
        $stmt->bindParam(':default_address', $user['default'], \PDO::PARAM_STR);
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
            return true;
        } else {
            return false;
        }
    }
}
