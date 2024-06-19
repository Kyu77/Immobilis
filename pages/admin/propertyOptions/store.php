<?php 
session_start();
// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si la requête HTTP est de type POST, sinon redirige vers la page de connexion
if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si le formulaire n'est pas vide et si le champ "name" est défini dans $_POST
if (!empty($_POST) && isset($_POST["name"])){
    // Inclusion des fichiers de connexion à la base de données et de gestion des options de propriété
    require "../../../database/connexion.php";
    require "../../../database/PropertyOptions.php";
    
    // Connexion à la base de données
    $pdo = Database::dbConnection();
    // Création d'une instance de la classe PropertyOptions avec la connexion PDO
    $propertyOptions = new PropertyOptions($pdo);
    
    // Récupération et nettoyage du nom de l'option de propriété
    $name = htmlentities($_POST["name"]);
    
    // Appel de la méthode store() pour ajouter l'option de propriété dans la base de données
    $result = $propertyOptions->store($name);
    
    // Vérifie si l'ajout a réussi ou non
    if ($result) {
        $_SESSION["success"] = "L'option du bien a été ajoutée";
    } else {
        $_SESSION["error"] = "Erreur lors de l'ajout";
    }
    
    // Redirection vers la page de création d'une nouvelle option de propriété
    header("Location: /immobilis/pages/admin/propertyOptions/create.php");
}
?>
