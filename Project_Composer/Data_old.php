<?php

class Database
{
    private $host = 'localhost';
    private $db = 'product_store';
    private $user = 'root';
    private $password = 'root123';
    public function connect()
    {
        try {
            return new PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->user, $this->password);
                        
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    

}

$pdo = new Database();
$dbConn = $pdo->connect();
$result = $dbConn->query("show tables");
echo "<pre>";
while ($row = $result->fetch()){
    print_r($row);
}