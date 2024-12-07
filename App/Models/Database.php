<?php

class Database{
    private $pdo;

    public function __construct(){
        $host = "localhost";
        $port = "3306";
        $database = "Service_provider";
        $username = "root";
        $password = "";

        try{
            $this->pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8",$username,$password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Could not connect to the database: " . $e->getMessage());
        }
    }

    public function query($sql, $params=[]){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function execute($sql, $params=[]){
        $stmt = $this->pdo->prepare($sql);
       return $stmt->execute($params);
    }
    public function prepare($query) {
        $stmt =  $this->pdo->prepare($query);
        return $stmt;
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}