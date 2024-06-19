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

// Vérifie si le formulaire a été soumis et que les champs "name" et "id" sont présents dans les données POST
if (!empty($_POST) && isset($_POST["name"]) && isset($_POST["id"])) {
    // Récupère et nettoie l'ID et le nom du type de bien à mettre à jour
    $id = intval(htmlentities($_POST["id"]));
    $name = htmlentities($_POST["name"]);

    // Inclusions des fichiers requis pour la connexion à la base de données et la manipulation des types de biens
    require "../../../database/connexion.php";
    require "../../../database/PropertyType.php";

    // Établit la connexion à la base de données
    $pdo = Database::dbConnection();

    // Instancie la classe PropertyType pour interagir avec la table des types de biens
    $propertyType = new PropertyType($pdo);

    // Appelle la méthode updateById() pour mettre à jour le type de bien dans la base de données
    $result = $propertyType->updateById($id, $name);

    // Vérifie si la mise à jour s'est bien déroulée
    if ($result) {
        $_SESSION["success"] = "Le type a été mis à jour"; // Message de succès à afficher
    } else {
        $_SESSION["error"] = "Erreur lors de la mise à jour"; // Message d'erreur à afficher
    }

    // Redirige l'utilisateur vers la page principale des types de biens après traitement
    header("Location: /immobilis/pages/admin/propertyType/index.php");
}
?>
