<?php
session_start();

// Vérifie si l'utilisateur est connecté. Si non, le redirige vers la page de connexion.
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si la requête HTTP est de type POST. Si non, redirige également vers la page de connexion.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si les données POST ne sont pas vides et si les champs "name" et "id" sont définis.
if (!empty($_POST) && isset($_POST["name"]) && isset($_POST["id"])) {

    // Récupération et nettoyage des valeurs des champs "id" et "name".
    $id = intval(htmlentities($_POST["id"]));
    $name = htmlentities($_POST["name"]);

    // Inclusion des fichiers de connexion à la base de données et de la classe PropertyType.
    require "../../../database/connexion.php";
    require "../../../database/PropertyType.php";

    // Connexion à la base de données
    $pdo = Database::dbConnection();

    // Instanciation de la classe PropertyType avec la connexion PDO établie.
    $propertyType = new PropertyType($pdo);

    // Appel de la méthode updateById() pour mettre à jour le type de propriété.
    $result = $propertyType->updateById($id, $name);

    // Vérifie si la mise à jour a été effectuée avec succès.
    if ($result) {
        $_SESSION["success"] = "Le type a été mis à jour";
    } else {
        $_SESSION["error"] = "Erreur lors de la mise à jour";
    }

    // Redirection vers une autre page après le traitement du formulaire.
    header("Location: /immobilis/pages/partials/properties/update.properties.php");
    exit; // Arrête l'exécution du script après la redirection
}
?>
