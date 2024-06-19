<?php

// Définition de la classe Option
class Option
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo) {}

    // Méthode pour récupérer toutes les options de la base de données
    public function findAll() {
        // Requête SQL pour sélectionner toutes les options
        $query = "SELECT * FROM immobilis.options";
        
        // Exécution directe de la requête SQL
        $stmt = $this->pdo->query($query);
        
        // Retourne tous les résultats sous forme de tableau
        return $stmt->fetchAll();
    }

    // Méthode pour insérer une nouvelle option dans la base de données
    public function store(string $name) {
        // Requête SQL pour insérer une nouvelle option
        $query = "INSERT INTO immobilis.options(name) VALUES (?)";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec le nom fourni
        return $stmt->execute([$name]);
    }

    // Méthode pour mettre à jour une option par son ID
    public function updateById(int $id, string $name) {
        // Requête SQL pour mettre à jour une option par son ID
        $query = "UPDATE immobilis.options SET name = ? WHERE id = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec les valeurs fournies
        return $stmt->execute([$name, $id]);
    }

    // Méthode pour récupérer une option par son ID
    public function findById(int $id) {
        // Requête SQL pour sélectionner une option par son ID
        $query = "SELECT * FROM immobilis.options WHERE id = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec l'ID fourni
        $stmt->execute([$id]);
        
        // Retourne le résultat sous forme de tableau ou false si non trouvé
        return $stmt->fetch();
    }

    // Méthode pour supprimer une option par son ID
    public function deleteById(int $id) {
        // Requête SQL pour supprimer une option par son ID
        $query = "DELETE FROM immobilis.options WHERE id = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec l'ID fourni
        return $stmt->execute([$id]);
    }
}
?>