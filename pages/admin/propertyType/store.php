<?php
// Démarre la session PHP
session_start();

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie que la requête HTTP est de type POST, sinon redirige également vers la page de connexion
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si le formulaire a été soumis et si le champ "name" est présent dans les données POST
if (!empty($_POST) && isset($_POST["name"])) {
    // Inclusions des fichiers requis pour la connexion à la base de données et la manipulation des types de biens
    require "../../../database/connexion.php";
    require "../../../database/PropertyType.php";

    // Établit la connexion à la base de données
    $pdo = Database::dbConnection();

    // Instancie la classe PropertyType pour interagir avec la table des types de biens
    $propertyType = new PropertyType($pdo);

    // Récupère et nettoie le nom du type de bien à ajouter
    $name = htmlentities($_POST["name"]);

    // Appelle la méthode store() pour ajouter le nouveau type de bien dans la base de données
    $result = $propertyType->store($name);

    // Vérifie si l'ajout s'est bien déroulé
    if ($result) {
        $_SESSION["success"] = "Le type de bien a été ajouté"; // Message de succès à afficher
    } else {
        $_SESSION["error"] = "Erreur lors de l'ajout"; // Message d'erreur à afficher
    }

    // Redirige l'utilisateur vers la page de création de type de bien, après traitement
    header("Location: /immobilis/pages/admin/propertyType/create.php");
}
?>





