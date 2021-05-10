<?php 
  class Database {
    // DB Params for local
    // private $host = 'localhost';
    // private $db_name = 'quotesdb';
    // private $username = 'root';
    
    
    // DB Params for Heroku
    private $conn;

    // DB Connect
    public function connect() {
      $url = getenv('JAWSDB_URL');
      $dbparts = parse_url($url);

      $hostname = $dbparts['host'];
      $username = $dbparts['user'];
      $password = $dbparts['pass'];
      $database = ltrim($dbparts['path'],'/');

      $dsn = "mysql:host={$hostname};dbname={$database}";
      $this->conn = null;

      try { 
        $this->conn = new PDO($dsn, $username, $password);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }