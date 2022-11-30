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
        $deleted = 'no';
        $stmt = $this->conn->prepare("INSERT INTO user_addresses (
            user_id,address,postal_code,city,state,country,address_type,default_address,created_on,modified_on,deleted) 
            VALUES (:user_id,:address,:postal_code,:city,:state,:country,:address_type,:default_address,:created_on,:modified_on,:deleted)");

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
        $stmt->bindParam(':deleted', $deleted);
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

    public function updateUserAddress($address)
    {
        $stmt = $this->conn->prepare("UPDATE user_addresses SET address=:address,postal_code=:postal_code,
                    city=:city,state=:state,country=:country,address_type=:address_type,default_address=:default_address,
                    modified_on=:modified_on,deleted=:deleted WHERE id=:id");
        $currentTime = date("Y-m-d H:i:s");
        $deleted = 'no';
        $stmt->bindParam(':id', $address['id'], \PDO::PARAM_INT);
        $stmt->bindParam(':address', $address['address'], \PDO::PARAM_STR);
        $stmt->bindParam(':postal_code', $address['pincode'], \PDO::PARAM_STR);
        $stmt->bindParam(':city', $address['city'], \PDO::PARAM_STR);
        $stmt->bindParam(':state', $address['state'], \PDO::PARAM_STR);
        $stmt->bindParam(':country', $address['country'], \PDO::PARAM_STR);
        $stmt->bindParam(':address_type', $address['address_type'], \PDO::PARAM_STR);
        $stmt->bindParam(':default_address', $address['default'], \PDO::PARAM_STR);
        $stmt->bindParam(':modified_on', $currentTime);
        $stmt->bindParam(':deleted', $deleted, \PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }

    public function updateUserDetails($user)
    {
        $stmt = $this->conn->prepare("UPDATE users SET first_name=:firstname,last_name=:lastname,
                    password=:password,phone_no=:phoneno,gender=:gender,email=:email,modified_on=:modified 
                    WHERE id=:userid");
                    
        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':userid', $user['userid'], \PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $stmt->bindParam(':password', $user['password_1'], \PDO::PARAM_STR);
        $stmt->bindParam(':phoneno', $user['phoneno'], \PDO::PARAM_INT);
        $stmt->bindParam(':gender', $user['gender'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $user['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':modified', $currentTime);
       
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }

    public function updateUserPassword($user)
    {
        $stmt = $this->conn->prepare("UPDATE users SET password=:password,modified_on=:modified
                    WHERE id=:id");
                    
        $currentTime = date("Y-m-d H:i:s");
        $stmt->bindParam(':id', $user['userid'], \PDO::PARAM_INT);
        $stmt->bindParam(':password', $user['password_1'], \PDO::PARAM_STR);
        $stmt->bindParam(':modified', $currentTime);
       
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }

    public function deleteUserAddress($addressId) 
    {
        $stmt = $this->conn->prepare("UPDATE user_addresses SET deleted=:deleted,modified_on=:modified_on WHERE id=:id");
                    
        $currentTime = date("Y-m-d H:i:s");
        $deleted = 'yes';
        $stmt->bindParam(':id', $addressId, \PDO::PARAM_INT);
        $stmt->bindParam(':deleted', $deleted, \PDO::PARAM_STR);
        $stmt->bindParam(':modified_on', $currentTime);
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return true;
    }

}
