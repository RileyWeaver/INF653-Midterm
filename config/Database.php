<?php
class Database {
    
    private $host = 'localhost';
    private $port = '5432';
    private $db_name = 'quotesdb';
    private $username = 'postgres';
    private $password = 'postgres';

    private $conn;

    public function __construct(){
        
        $this->host     = getenv('HOST')     ?: $this->host;
        $this->port     = getenv('DB_PORT')  ?: $this->port;  
        $this->db_name  = getenv('DB_NAME')  ?: $this->db_name;
        $this->username = getenv('USERNAME') ?: $this->username;
        $this->password = getenv('PASSWORD') ?: $this->password;
    }

    public function connect() {
        $this->conn = null;
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
