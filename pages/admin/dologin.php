<?php
// Démarre une session PHP
session_start();

// Vérifie si la requête HTTP est de type GET, redirige vers la page de connexion si c'est le cas
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Termine l'exécution du script après la redirection
}

// Vérifie si le formulaire a été soumis (POST) et si les champs email et password sont définis
if (!empty($_POST) && isset($_POST["email"]) && isset($_POST["password"])) {

    // Inclusion des fichiers de connexion à la base de données et de la classe Admin
    require "../../database/connexion.php";
    require "../../database/Admin.php";

    // Connexion à la base de données
    $pdo = Database::dbConnection();
    $admin = new Admin($pdo);

    // Récupération et sécurisation des valeurs des champs email et password du formulaire
    $email = htmlentities($_POST["email"]);
    $password = htmlentities($_POST["password"]);

    // Récupère les informations de l'administrateur à partir de l'email fourni
    $user = $admin->getAdminByEmail($email);

    // Vérifie si aucun utilisateur n'est trouvé avec l'email fourni
    if (!$user) {
        $_SESSION["error"] = "Email invalide";
        header("Location: /immobilis/pages/admin/login.php");
        exit; // Termine l'exécution du script après la redirection
    } else {
        // Vérifie si le mot de passe fourni correspond au mot de passe hashé dans la base de données
        $match = password_verify($password, $user["password"]);

        // Si les mots de passe ne correspondent pas
        if (!$match) {
            $_SESSION["error"] = "Mot-de-passe invalide";
            header("Location: /immobilis/pages/admin/login.php");
            exit; // Termine l'exécution du script après la redirection
        } else {
            // Création de la session pour l'administrateur connecté
            $_SESSION["connected"] = true; // Indique que l'administrateur est connecté
            $_SESSION["admin_id"] = $user["id"]; // Stocke l'ID de l'administrateur dans la session
            $_SESSION["success"] = "Vous êtes connecté"; // Message de succès
            header("Location: /immobilis/pages/admin/dashboard.php");
            exit; // Termine l'exécution du script après la redirection
        }
    }
}
?>
