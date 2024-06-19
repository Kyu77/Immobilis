<?php
session_start(); // Démarre la session PHP pour utiliser les variables de session

// Vérifie si l'utilisateur est connecté ou redirige vers la page de connexion si ce n'est pas le cas
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie que la méthode de requête est POST, sinon redirige également vers la page de connexion
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si le formulaire POST n'est pas vide et si les champs "name" et "id" sont définis
if (!empty($_POST) && isset($_POST["name"]) && isset($_POST["id"])) {
    // Récupère et nettoie l'ID et le nom de l'option à partir du formulaire POST
    $id = intval(htmlentities($_POST["id"]));
    $name = htmlentities($_POST["name"]);

    // Inclusion des fichiers de connexion à la base de données et de la classe Option
    require  "../../../database/connexion.php";
    require  "../../../database/Option.php";

    $pdo = Database::dbConnection(); // Connexion à la base de données via la méthode dbConnection
    $option = new Option($pdo); // Instanciation de la classe Option avec la connexion PDO établie

    // Appelle la méthode updateById() de la classe Option pour mettre à jour l'option dans la base de données
    $result = $option->updateById($id, $name);

    // Vérifie si la mise à jour a réussi ou non et définit un message de succès ou d'erreur dans la session
    if ($result) {
        $_SESSION["success"] = "L'option a été mise à jour";
    } else {
        $_SESSION["error"] = "Erreur lors de la mise à jour de l'option";
    }

    header("Location: /immobilis/pages/admin/options/index.php"); // Redirige vers la page principale des options
    exit; // Arrête l'exécution du script après la redirection
}
