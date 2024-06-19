<?php

// Définition de la classe Admin
class Admin {

    // Constructeur de la classe qui initialise l'instance PDO
    public function __construct(private PDO $pdo) {}

    // Méthode pour récupérer tous les administrateurs de la base de données
    public function getAdmins() {
        // Requête SQL pour sélectionner tous les administrateurs
        $query = "SELECT * FROM immobilis.admins";
        
        // Exécution directe de la requête SQL
        $stmt = $this->pdo->query($query);
        
        // Retourne tous les résultats sous forme de tableau
        return $stmt->fetchAll();
    }

    // Méthode pour créer un nouvel administrateur dans la base de données
    public function createAdmin() {
        // Données de l'administrateur par défaut
        $firstname = "admin";
        $lastname = "admin";
        $email = "admin@admin.fr";
        
        // Hachage du mot de passe pour la sécurité
        $password = password_hash("root", PASSWORD_BCRYPT);

        // Requête SQL pour insérer un nouvel administrateur
        $query = "INSERT INTO immobilis.admins (firstname, lastname, email, password)
                  VALUES (?, ?, ?, ?)";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec les valeurs fournies
        $stmt->execute([$firstname, $lastname, $email, $password]);
    }

    // Méthode pour récupérer un administrateur par son email
    public function getAdminByEmail(string $email) {
        // Requête SQL pour sélectionner un administrateur par email
        $query = "SELECT * FROM immobilis.admins WHERE email = ?";
        
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare($query);
        
        // Exécution de la requête avec l'email fourni
        $stmt->execute([$email]);
        
        // Retourne le résultat sous forme de tableau ou false si non trouvé
        return $stmt->fetch();
    }

}
?>