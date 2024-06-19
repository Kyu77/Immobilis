<?php

// Définition de la classe Address
class Address
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo)
    {
    }

    // Méthode pour insérer une nouvelle adresse dans la base de données
    public function store(int $number, string $street, string $city, string $zipcode): int
    {
        // Requête SQL pour insérer une nouvelle adresse
        $query = "INSERT INTO immobilis.addresses (street, city, zipcode, number)
                  VALUES (?, ?, ?, ?)";
        
        // Prépare la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécute la requête avec les valeurs fournies
        $stmt->execute([$street, $city, $zipcode, $number]);
        
        // Retourne l'ID de la dernière insertion converti en entier
        return intval($this->pdo->lastInsertId());
    }

    // Méthode pour mettre à jour une adresse existante dans la base de données
    public function update(int $id, string $street, string $city, string $zipcode, int $number): bool
    {
        // Requête SQL pour mettre à jour une adresse existante
        $query = "UPDATE immobilis.addresses ad
                  JOIN properties pro ON pro.addresses_id = ad.id
                  SET ad.street = ?, ad.city = ?, ad.zipcode = ?, ad.number = ?
                  WHERE pro.id = ?";
        
        // Prépare la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécute la requête avec les valeurs fournies
        return $stmt->execute([$street, $city, $zipcode, $number, $id]);
    }
}

?>