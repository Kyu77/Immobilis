<?php
session_start();

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie que la requête HTTP est de type POST, sinon redirige vers la page de connexion
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si le formulaire a été soumis (POST non vide) et si l'ID est défini dans $_POST
if (!empty($_POST) && isset($_POST["id"])) {
    // Récupère l'ID de l'élément à supprimer depuis $_POST et le sécurise avec intval(htmlentities())
    $id = intval(htmlentities($_POST["id"]));

    // Inclusions des fichiers de connexion à la base de données et de la classe PropertyType
    require "../../../database/connexion.php";
    require "../../../database/PropertyType.php";

    // Établit la connexion à la base de données
    $pdo = Database::dbConnection();

    // Instanciation de la classe PropertyType pour gérer les types de biens
    $propertyType = new PropertyType($pdo);

    // Appelle la méthode pour supprimer un type de bien par son ID
    $result = $propertyType->deleteById($id);

    // Vérifie si la suppression a réussi ou non et définit un message flash approprié
    if ($result) {
        $_SESSION["success"] = "Le type a été supprimé avec succès";
    } else {
        $_SESSION["error"] = "Erreur lors de la suppression du type";
    }

    // Redirige l'utilisateur vers la page de liste des types de bien après l'opération
    header("Location: /immobilis/pages/admin/propertyType/index.php");
    exit; // Assure l'arrêt complet de l'exécution après la redirection
}
?>
