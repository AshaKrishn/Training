<?php
namespace StoreApp\Data;

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
            $this->conn = new \PDO('mysql:host='.$this->host.';dbname='.$this->db, $this->user, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //return $this->conn;
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    

}
