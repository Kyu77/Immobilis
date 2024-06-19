<?php
session_start();
$method = $_SERVER["REQUEST_METHOD"];

// Vérifie si la méthode de la requête n'est pas POST ou si l'utilisateur n'est pas connecté
if ($method !== "POST" || !isset($_SESSION["connected"]) || $_SESSION["connected"] !== true) {
    header("Location: /immobilis/index.php"); // Redirection vers la page d'accueil
}

$_SESSION["success"] = "Vous êtes déconnecté"; // Définition d'un message de succès (qui ne sera jamais affiché)

header("Location: /immobilis/index.php"); // Redirection vers la page d'accueil

session_destroy(); // Destruction de la session en cours


