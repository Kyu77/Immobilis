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

// Vérifie si le formulaire POST n'est pas vide et si le champ "name" est défini
if (!empty($_POST) && isset($_POST["name"])) {
    // Inclusion des fichiers de connexion à la base de données et de la classe Option
    require "../../../database/connexion.php";
    require "../../../database/Option.php";

    $pdo = Database::dbConnection(); // Connexion à la base de données via la méthode dbConnection
    $option = new Option($pdo); // Instanciation de la classe Option avec la connexion PDO établie

    // Récupère et nettoie le nom de l'option à partir du formulaire POST
    $name = htmlentities($_POST["name"]);

    // Appelle la méthode store() de la classe Option pour ajouter l'option dans la base de données
    $result = $option->store($name);

    // Vérifie si l'ajout a réussi ou non et définit un message de succès ou d'erreur dans la session
    if ($result) {
        $_SESSION["success"] = "L'option a bien été ajoutée";
    } else {
        $_SESSION["error"] = "Erreur lors de l'ajout de l'option";
    }

    header("Location: /immobilis/pages/admin/options/create.php"); // Redirige vers la page de création d'options
    exit; // Arrête l'exécution du script après la redirection
}




