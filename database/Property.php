<?php

// Définition de la classe Property
class Property
{
    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo) {}

    // Méthode pour insérer une nouvelle propriété dans la base de données
    public function store(
        string $title,
        int $price,
        int $surface,
        int $rooms,
        int $floor,
        int $bedrooms,
        int $bathrooms,
        string $description,
        string $images,
        int $typeId,
        int $addressId
    ) {
        // Requête SQL pour insérer une nouvelle propriété
        $query = "INSERT INTO immobilis.properties(title, description, images, surface, price, rooms, floor, bedrooms, bathrooms, property_type_id, address_id)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec les valeurs fournies
        $stmt->execute([$title, $description, $images, $surface, $price, $rooms, $floor, $bedrooms, $bathrooms, $typeId, $addressId]);
        // Retourne l'ID de la dernière insertion
        return intval($this->pdo->lastInsertId());
    }

    // Méthode pour récupérer toutes les propriétés
    public function findAll() {
        // Requête SQL pour sélectionner toutes les propriétés avec quelques détails
        $query = "SELECT p.id, p.title, p.images, p.price, a.city, pt.name
                  FROM immobilis.properties p
                  JOIN immobilis.property_types pt on p.property_type_id = pt.id
                  JOIN addresses a on a.id = p.address_id";
        // Exécution directe de la requête SQL
        $stmt = $this->pdo->query($query);
        // Retourne tous les résultats sous forme de tableau
        return $stmt->fetchAll();
    }

    // Méthode pour récupérer une propriété par son ID
    public function findById(int $id) {
        // Requête SQL pour sélectionner une propriété et ses détails par son ID
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
            ),
            'options', (
                SELECT JSON_ARRAYAGG(o.name)
                FROM immobilis.options o
                JOIN properties_options po on o.id = po.options_id
                WHERE po.properties_id = p.id
            )
        ) as property
        FROM immobilis.properties p
        JOIN immobilis.property_types pt on p.property_type_id = pt.id
        JOIN addresses a on a.id = p.address_id
        WHERE p.id = ?
        EOF;
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID fourni
        $stmt->execute([$id]);
        // Retourne le résultat sous forme de tableau ou false si non trouvé
        return $stmt->fetch();
    }

    // Méthode pour insérer un contact associé à une propriété
    public function contact(string $firstname, string $lastname, string $email, string $message, int $property_id) {
        // Requête SQL pour insérer un nouveau contact
        $query = "INSERT INTO immobilis.contacts(firstname, lastname, email, message, property_id)
                  VALUES (?, ?, ?, ?, ?)";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec les valeurs fournies
        return $stmt->execute([$firstname, $lastname, $email, $message, $property_id]);
    }

    // Méthode pour sélectionner les images d'une propriété par son ID
    public function selectImages(int $id) {
        // Requête SQL pour sélectionner les images d'une propriété par son ID
        $query = "SELECT images FROM immobilis.properties WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID fourni
        $stmt->execute([$id]);
        // Retourne le résultat sous forme de tableau ou false si non trouvé
        return $stmt->fetch(); 
    }

    // Méthode pour supprimer les options d'une propriété par son ID
    public function deletePropertiesOptionsById($id) {
        // Requête SQL pour supprimer les options d'une propriété par son ID
        $query = "DELETE opt FROM immobilis.properties_options opt WHERE properties_id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID fourni
        return $stmt->execute([$id]);
    }

    // Méthode pour supprimer une propriété et son adresse par l'ID de la propriété
    public function deletePropertyAndAddressById($id) {
        // Requête SQL pour supprimer une propriété et son adresse par l'ID de la propriété
        $query = "DELETE ad FROM immobilis.addresses ad JOIN properties pro ON pro.addresses_id = ad.id WHERE pro.id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec l'ID fourni
        return $stmt->execute([$id]);
    }

    // Méthode pour mettre à jour les images d'une propriété par son ID
    public function updateImages($id, $images) {
        // Requête SQL pour mettre à jour les images d'une propriété par son ID
        $query = "UPDATE immobilis.properties SET images = ? WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec les valeurs fournies
        return $stmt->execute([$images, $id]);
    }

    // Méthode pour mettre à jour une propriété par son ID
    public function update(
        $id, 
        $title,
        $price,
        $surface,
        $rooms,
        $floor,
        $bedrooms,
        $bathrooms,
        $description,
        $typeId
    ) {
        // Requête SQL pour mettre à jour une propriété par son ID
        $query = "UPDATE immobilis.properties 
                  SET title = ?, price = ?, surface = ?, rooms = ?, floor = ?, bedrooms = ?, bathrooms = ?, description = ?, property_type_id = ? 
                  WHERE id = ?";
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        // Exécution de la requête avec les valeurs fournies
        return $stmt->execute([$title, $price, $surface, $rooms, $floor, $bedrooms, $bathrooms, $description, $typeId, $id]);
    }
}
?>
