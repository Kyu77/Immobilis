<?php

// Définition de la classe Database
class Database {

    // Propriété statique pour stocker l'instance unique de PDO
    private static ?PDO $instance = null;

    // Méthode statique pour obtenir la connexion à la base de données
    public static function dbConnection() : PDO {
        // Vérifie si l'instance PDO n'a pas déjà été créée
        if (self::$instance === null) {
            try {
                // Crée une nouvelle instance de PDO avec les paramètres de connexion
                self::$instance = new PDO("mysql:host=localhost;dbname=immobilis", "root", "15082003hdc");
                
                // Définit le mode d'erreur de PDO pour lever des exceptions
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Définit le mode de récupération par défaut pour obtenir les résultats sous forme de tableau associatif
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $exception) {
                // Affiche le message d'erreur en cas d'exception
                echo $exception->getMessage();
            }
        }
        // Retourne l'instance de PDO
        return self::$instance;
    }
}
?>