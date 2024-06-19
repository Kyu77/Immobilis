<?php

// Définition de la classe Contact
class Contact
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo) {}

    // Méthode pour récupérer tous les contacts de la base de données
    public function findAll() {
        // Requête SQL pour sélectionner tous les contacts
        $query = "SELECT * FROM immobilis.contacts";
        
        // Exécution directe de la requête SQL
        $stmt = $this->pdo->query($query);
        
        // Retourne tous les résultats sous forme de tableau
        return $stmt->fetchAll();
    }

    // Méthode pour supprimer un contact par son ID
    public function deleteById(int $id) {
        // Requête SQL pour supprimer un contact par son ID
        $query = "DELETE FROM immobilis.contacts WHERE id = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec l'ID fourni
        return $stmt->execute([$id]);
    }
}
?>
