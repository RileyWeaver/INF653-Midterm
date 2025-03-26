<?php
class Author {
    
    private $conn;

   
    private $table = 'authors';

    
    private $id;
    private $author;

   
    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function setId($id) {
        $this->id = $id;
    }
    public function setAuthor($author) {
        $this->author = $author;
    }

   
    public function getId() {
        return $this->id;
    }
    public function getAuthor() {
        return $this->author;
    }

    // READ all authors
    public function read() {
        $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt; 
    }

    // READ single author by id
    public function read_single() {
        $query = 'SELECT id, author 
                  FROM ' . $this->table . ' 
                  WHERE id = :id 
                  LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // CREATE author
    public function create() {
       
        $query = 'INSERT INTO ' . $this->table . ' (author) 
                  VALUES (:author)';

        $stmt = $this->conn->prepare($query);

        // Bind
        $stmt->bindParam(':author', $this->author);

        // Execute
        if ($stmt->execute()) {
            
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // UPDATE author
    public function update() {
       
        $query = 'UPDATE ' . $this->table . '
                  SET author = :author
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        
        if ($stmt->execute()) {
           
            return ($stmt->rowCount() > 0);
        }
        return false;
    }

    // DELETE author
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            
            return ($stmt->rowCount() > 0);
        }
        return false;
    }
}
