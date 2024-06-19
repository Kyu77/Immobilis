<?php
session_start(); // Démarrage de la session PHP pour gérer les variables de session

// Vérification de la connexion de l'utilisateur via la variable de session "connected"
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit; // Arrêt de l'exécution du script après la redirection
}

// Vérification de la méthode de requête HTTP, doit être "POST" pour traiter le formulaire de suppression
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php"); // Redirection vers la page de connexion si la méthode n'est pas "POST"
    exit; // Arrêt de l'exécution du script après la redirection
}

// Vérification si le formulaire a été soumis et si l'ID de l'option à supprimer est présent dans $_POST
if (!empty($_POST) && isset($_POST["id"])) {
    $id = intval(htmlentities($_POST["id"])); // Récupération et sécurisation de l'ID de l'option à supprimer

    // Inclusion des fichiers de connexion à la base de données et de la classe Option
    require "../../../database/connexion.php";
    require "../../../database/Option.php";

    // Connexion à la base de données
    $pdo = Database::dbConnection();
    
    // Instanciation de la classe Option avec la connexion PDO établie
    $option = new Option($pdo);

    // Appel de la méthode deleteById pour supprimer l'option avec l'ID spécifié
    $result = $option->deleteById($id);

    // Gestion du résultat de la suppression
    if ($result) {
        $_SESSION["success"] = "l'option a ete supprime"; // Message de succès si la suppression a réussi
    } else {
        $_SESSION["error"] = "erreur lors de la suppression"; // Message d'erreur si la suppression a échoué
    }

    // Redirection vers la page principale des options après le traitement
    header("Location: /immobilis/pages/admin/options/index.php");
}
?>
