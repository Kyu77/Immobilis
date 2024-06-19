<?php

// Définition de la classe PropertyOption
class PropertyOption
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo) {}

    // Méthode pour insérer des options pour une propriété
    public function store(int $propertyId, array $optionsIds) {
        // Initialisation de la variable de résultat
        $result = false;

        // Boucle sur chaque option ID dans le tableau des options
        foreach ($optionsIds as $optionId) {
            // Requête SQL pour insérer une association entre une propriété et une option
            $query = "INSERT INTO immobilis.properties_options(properties_id, options_id) VALUES (?, ?)";
            // Préparation de la requête SQL
            $stmt = $this->pdo->prepare($query);
            // Exécution de la requête avec l'ID de la propriété et l'ID de l'option
            $result = $stmt->execute([$propertyId, $optionId]);
        }

        // Retourne le résultat de la dernière exécution de la requête
        return $result;
    }
}
?>
