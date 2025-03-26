<?php
class Quote {
    private $conn;
    private $table = 'quotes';

  
    private $id;
    private $quote;
    private $author_id;
    private $category_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function setId($id) {
        $this->id = $id;
    }
    public function setQuote($quote) {
        $this->quote = $quote;
    }
    public function setAuthorId($author_id) {
        $this->author_id = $author_id;
    }
    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
    }

   
    public function read() {
        $query = "SELECT q.id, q.quote, a.author AS author, c.category AS category
                  FROM " . $this->table . " q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id
                  ORDER BY q.id ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function read_single() {
        $query = "SELECT q.id, q.quote, a.author AS author, c.category AS category
                  FROM " . $this->table . " q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

   
    public function create() {
        $query = "INSERT INTO " . $this->table . " (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }


    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET quote = :quote, author_id = :author_id, category_id = :category_id
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
          
            return ($stmt->rowCount() > 0);
        }
        return false;
    }

    // DELETE 
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            
            return ($stmt->rowCount() > 0);
        }
        return false;
    }
}
