<?php

// Définition de la classe PropertyOptions
class PropertyOptions
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo){}

    // Méthode pour récupérer toutes les options
    public function findAll(){
        // Requête SQL pour sélectionner toutes les options
        $query = "SELECT * FROM immobilis.options";
        // Exécution de la requête SQL
        $stmt = $this->pdo->query($query);
        // Retourne toutes les lignes récupérées
        return $stmt->fetchAll();
    }

    // Méthode pour insérer une nouvelle option
    public function store(string $name){
        // Requête SQL pour insérer une nouvelle option
        $query = "INSERT INTO immobilis.options(name) VALUES (?)";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec le nom de l'option
        return $stmt->execute([$name]);
    }

    // Méthode pour mettre à jour une option par son ID
    public function updateById(int $id, string $name){
        // Requête SQL pour mettre à jour le nom d'une option par son ID
        $query = "UPDATE immobilis.options SET name = ? WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec le nouveau nom et l'ID de l'option
        return $stmt->execute([$name, $id]);
    }

    // Méthode pour récupérer une option par son ID
    public function findById(int $id){
        // Requête SQL pour sélectionner une option par son ID
        $query = "SELECT * FROM immobilis.options WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID de l'option
        $stmt->execute([$id]);
        // Retourne la ligne récupérée
        return $stmt->fetch();
    }

    // Méthode pour supprimer une option par son ID
    public function deleteById(int $id){
        // Requête SQL pour supprimer une option par son ID
        $query = "DELETE FROM immobilis.options WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID de l'option
        return $stmt->execute([$id]);
    }
}

?>
