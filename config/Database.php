<?php 
  class Database {
    // DB Params for local
    // private $host = 'localhost';
    // private $db_name = 'quotesdb';
    // private $username = 'root';
    
    
    // DB Params for Heroku
    private $host = 'frwahxxknm9kwy6c.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
    private $db_name = 'i22jce46fiw00cqe'
    private $password = 'mp8kaoxektltu4de';
    private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username,
        $this->password
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }