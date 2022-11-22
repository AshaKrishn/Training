<?php

namespace StoreApp\Data;

use StoreApp\Data\Database;
require_once $_SERVER['DOCUMENT_ROOT']."/git_repo/Training/MyStore/vendor/autoload.php";
//require_once "../../vendor/autoload.php";
ini_set('display_errors', 1);

class Registration 
{
    public function registerUser($newUser)
    {
        $db = $this->getDbConnection();
        $stmt = $db->prepare("INSERT INTO users (
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

        $stmt->execute();
        if ($db->lastInsertId()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUsername($username)
    {
        $db = $this->getDbConnection();
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        echo "In check username function---->".print_r($stmt->fetchColumn());
        if ($stmt->fetchColumn()) {
            return false;
        } else {
            return true;
        }
    }

    public function getDbConnection()
    {
        $pdo = new Database();
        return $pdo->conn;
    }

    public function registerUser2($newUser)
    {
        echo "in function";
        echo "<pre>";
        print_r($newUser);
        $currentTime = date("Y-m-d H:i:s");
        $isLoggedStatus = 1;
        $firstname = $newUser['firstname'];
        $lastname = $newUser['lastname'];
        $username = $newUser['username'];
        $password = $newUser['password'];
        $phoneno = $newUser['phoneno'];
        $gender = $newUser['gender'];
        $email = $newUser['email'];

        $db = $this->getDbConnection();

        $query = "INSERT INTO users
                     (first_name,last_name,username,password,phone_no,gender,email,created_on,modified_on,is_logged) 
                     VALUES ('".$firstname."','".$lastname."','".$username."','".$password."','".$phoneno."','".$gender."','".$email."','".
                     $currentTime."','".$currentTime."','".$isLoggedStatus."')";


        $db->exec($query);
        if ($db->lastInsertId()) {
            echo "Data inserted successfully..!!";
            return true;
        } else {
            echo "Error in inserting data..!!";
            return false;
        }
    }
}
/*
        echo "<pre>";
        while ($row = $result->fetch()){
            print_r($row);
        }

        foreach ($newUser as $key => &$val) {
            $stmt->bindParam(':'.$key, $val);
            //echo "<br>key===>$key===val===>".$val;
        }


*/
