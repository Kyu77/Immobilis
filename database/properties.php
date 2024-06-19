<?php

// Définition de la classe properties
class properties
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo) {}

    // Méthode pour récupérer toutes les propriétés de la base de données
    public function findAll() {
        // Requête SQL pour sélectionner toutes les propriétés
        $query = "SELECT * FROM immobilis.properties";
        
        // Exécution directe de la requête SQL
        $stmt = $this->pdo->query($query);
        
        // Retourne tous les résultats sous forme de tableau
        return $stmt->fetchAll();
    }

    // Méthode pour insérer un nouveau type de propriété dans la base de données
    public function store(string $name) {
        // Requête SQL pour insérer un nouveau type de propriété
        $query = "INSERT INTO immobilis.property_types(name) VALUES (?)";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec le nom fourni
        return $stmt->execute([$name]);
    }

    // Méthode pour mettre à jour une propriété par son ID
    public function updateById(int $id, string $name, string $title, int $price, int $rooms, int $floor, int $bedrooms, int $surface, string $description, int $bathrooms, string $images, string $typeId, int $number, string $street, string $city, int $zipcode) {
        // Requête SQL pour sélectionner et mettre à jour une propriété en fonction de son ID
        $query = <<<EOF
        SELECT JSON_OBJECT(
            'id', p.id,
            'title', p.title,
            'description', p.description,
            'images', p.images,
            'surface', p.surface,
            'price', p.price,
            'rooms', p.rooms,
            'floor', p.floor,
            'bedrooms', p.bedrooms,
            'bathrooms', p.bathrooms,
            'address', (
                SELECT JSON_OBJECT(
                    'street', ad.street,
                    'number', ad.number,
                    'city', ad.city,
                    'zipcode', ad.zipcode
                )
                FROM immobilis.addresses ad
                WHERE p.address_id = ad.id
            )
        ) as properties
        FROM immobilis.properties p
        JOIN immobilis.property_types pt on p.property_type_id = pt.id
        JOIN addresses a on a.id = p.address_id
        WHERE p.id = ?
        EOF;
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec les valeurs fournies
        return $stmt->execute([$title, $name, $id, $price, $rooms, $floor, $bedrooms, $surface, $description, $bathrooms, $images, $typeId, $number, $street, $city, $zipcode]);
    }

    // Méthode pour récupérer une propriété par son ID
    public function findById(int $id) {
        // Requête SQL pour sélectionner une propriété par son ID
        $query = "SELECT * FROM immobilis.properties WHERE id = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec l'ID fourni
        $stmt->execute([$id]);
        
        // Retourne le résultat sous forme de tableau ou false si non trouvé
        return $stmt->fetch();
    }

    // Méthode pour supprimer une propriété par son ID
    public function deleteById(int $id) {
        // Requête SQL pour supprimer une propriété par son ID
        $query = "DELETE FROM immobilis.properties WHERE id = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec l'ID fourni
        return $stmt->execute([$id]);
    }
}
?>
