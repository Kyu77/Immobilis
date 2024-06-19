<?php 
// Démarrage de la session PHP
session_start();

// Vérification si l'utilisateur est connecté, sinon redirection vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");  
    exit; // Arrêt de l'exécution du script après la redirection
}

// Vérification de la méthode de requête HTTP, si ce n'est pas POST, redirection vers la page de connexion
if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrêt de l'exécution du script après la redirection
}

// Vérification si le formulaire POST contient l'index "id" et n'est pas vide
if (!empty($_POST) && isset($_POST["id"])){
    // Récupération et sécurisation de l'identifiant de l'option à supprimer
    $id = intval(htmlentities($_POST["id"]));

    // Inclusion des fichiers de connexion à la base de données et du modèle pour les options de propriété
    require "../../../database/connexion.php";
    require "../../../database/propertyOptions.php";

    // Connexion à la base de données
    $pdo = Database::dbConnection();
    
    // Création d'une instance de la classe PropertyOptions avec la connexion PDO
    $propertyOption = new PropertyOptions($pdo);

    // Appel de la méthode deleteById pour supprimer l'option de propriété par son identifiant
    $result = $propertyOption->deleteById($id);
    
    // Vérification du résultat de la suppression
    if ($result){
        $_SESSION["success"] = "L'option a été supprimée avec succès";
    } else {
        $_SESSION["error"] = "Erreur lors de la suppression de l'option";
    }

    // Redirection vers la page d'index des options de propriété après l'action
    header("Location: /immobilis/pages/admin/propertyOptions/index.php");
    exit; // Arrêt de l'exécution du script après la redirection
}
?>
