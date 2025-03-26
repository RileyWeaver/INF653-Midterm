<?php
class Category {
    private $conn;
    private $table = 'categories';

    
    private $id;
    private $category;

    
    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function setId($id) {
        $this->id = $id;
    }
    public function setCategory($category) {
        $this->category = $category;
    }

    
    public function getId() {
        return $this->id;
    }
    public function getCategory() {
        return $this->category;
    }

    // READ all 
    public function read() {
        $query = "SELECT id, category FROM " . $this->table . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ single 
    public function read_single() {
        $query = "SELECT id, category 
                  FROM " . $this->table . " 
                  WHERE id = :id
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // CREATE 
    public function create() {
        $query = "INSERT INTO " . $this->table . " (category)
                  VALUES (:category)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $this->category);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // UPDATE 
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET category = :category
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ($stmt->rowCount() > 0);
        }
        return false;
    }

    // DELETE 
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ($stmt->rowCount() > 0);
        }
        return false;
    }
}
