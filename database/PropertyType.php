<?php

// Définition de la classe PropertyType
class PropertyType
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo){}

    // Méthode pour récupérer tous les types de propriétés
    public function findAll() {
        // Requête SQL pour sélectionner tous les types de propriétés
        $query = "SELECT * FROM immobilis.property_types";
        // Exécution de la requête SQL
        $stmt = $this->pdo->query($query);
        // Retourne toutes les lignes récupérées
        return $stmt->fetchAll();
    }

    // Méthode pour insérer un nouveau type de propriété
    public function store(string $name) {
        // Requête SQL pour insérer un nouveau type de propriété avec un nom donné
        $query = "INSERT INTO immobilis.property_types(name) VALUES (?)";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec le nom du type de propriété
        return $stmt->execute([$name]);
    }

    // Méthode pour mettre à jour un type de propriété par son ID
    public function updateById(int $id, string $name){
        // Requête SQL pour mettre à jour le nom d'un type de propriété par son ID
        $query = "UPDATE immobilis.property_types SET name = ? WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec le nouveau nom et l'ID du type de propriété
        return $stmt->execute([$name, $id]);
    }

    // Méthode pour récupérer un type de propriété par son ID
    public function findById(int $id) {
        // Requête SQL pour sélectionner un type de propriété par son ID
        $query = "SELECT * FROM immobilis.property_types WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID du type de propriété
        $stmt->execute([$id]);
        // Retourne la ligne récupérée
        return $stmt->fetch();
    }

    // Méthode pour supprimer un type de propriété par son ID
    public function deleteById(int $id) {
        // Requête SQL pour supprimer un type de propriété par son ID
        $query = "DELETE FROM immobilis.property_types WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID du type de propriété
        return $stmt->execute([$id]);
    }
}

?>
