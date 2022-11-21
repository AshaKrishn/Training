<?php
//namespace StoreApp\Data;

class Database
{
    private $host = 'localhost';
    private $db = 'product_store';
    private $user = 'root';
    private $password = 'root123';
    public $conn;
    public function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->user, $this->password);
            return $this->conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    

}
/*
$pdo = new Database();
$result = $pdo->conn->query("show tables");
echo "<pre>";
while ($row = $result->fetch()){
    print_r($row);
}
*/