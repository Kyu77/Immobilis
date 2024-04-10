<?php

class Contact
{
     public function __construct(private PDO $pdo){}


    public function findAll() {
         $query = "SELECT * FROM immobilis.contacts";
         $stmt = $this->pdo->query($query);
         return $stmt->fetchAll();
    }

    public function deleteById(int $id) {
         $query = "DELETE FROM immobilis.contacts WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$id]);
    }
    
}