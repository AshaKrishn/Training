<?php
include_once('Database.php');
ini_set('display_errors', 1);
class Registration 
{
    
    public function registerUser($newUser)
    {
        echo "in function";
        echo "<pre>";
        print_r($newUser);
        
        $db = $this->getDbConnection();
        $stmt = $db->prepare("INSERT INTO users (
                                first_name,last_name,username,password,phone_no,gender,email,created_on,modified_on,is_logged) 
                                VALUES (:firstname,:lastname,:username,:password,:phoneno,:gender,:email,:created,:modified,:islogged)");
        
       
        
        $currentTime = date("Y-m-d H:i:s");
        $isLoggedStatus = 1;
        $newUser['gender'] = 'female';
        $stmt->bindParam(':firstname',$newUser['firstname'],PDO::PARAM_STR);
        $stmt->bindParam(':lastname',$newUser['lastname'],PDO::PARAM_STR);
        $stmt->bindParam(':username',$newUser['username'],PDO::PARAM_STR);
        $stmt->bindParam(':password',$newUser['password'],PDO::PARAM_STR);
        $stmt->bindParam(':phoneno',$newUser['phoneno'],PDO::PARAM_INT);
        $stmt->bindParam(':gender',$newUser['gender'],PDO::PARAM_STR);
        $stmt->bindParam(':email',$newUser['email'],PDO::PARAM_STR);
        $stmt->bindParam(':created',$currentTime);
        $stmt->bindParam(':modified',$currentTime);
        $stmt->bindParam(':islogged',$isLoggedStatus,PDO::PARAM_STR);
        
        $stmt->execute();
        if($db->lastInsertId()) {
            echo "Data inserted successfully..!!";
        } else {
            echo "Error in inserting data..!!";
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
        $gender = 'female';//$newUser['gender'];
        $email = $newUser['email'];
       
        $db = $this->getDbConnection();
        
        $query = "INSERT INTO users
                     (first_name,last_name,username,password,phone_no,gender,email,created_on,modified_on,is_logged) 
                     VALUES ('".$firstname."','".$lastname."','".$username."','".$password."','".$phoneno."','".$gender."','".$email."','".
                     $currentTime."','".$currentTime."','".$isLoggedStatus."')";

        
        $db->exec($query);
        if($db->lastInsertId()) {
            echo "Data inserted successfully..!!";
        } else {
            echo "Error in inserting data..!!";
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