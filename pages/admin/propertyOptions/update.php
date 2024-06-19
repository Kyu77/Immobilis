<?php
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si la requête HTTP est de type POST, sinon redirige vers la page de connexion
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si le formulaire n'est pas vide et si les champs "name" et "id" sont définis dans $_POST
if (!empty($_POST) && isset($_POST["name"]) && isset($_POST["id"])) {
    // Récupération et nettoyage de l'ID et du nom de l'option de propriété à mettre à jour
    $id = intval(htmlentities($_POST["id"]));
    $name = htmlentities($_POST["name"]);
    
    // Inclusion du fichier de connexion à la base de données et de la classe PropertyOptions
    require "../../../database/connexion.php";
    require "../../../database/PropertyOptions.php";
    
    // Connexion à la base de données
    $pdo = Database::dbConnection();
    
    // Création d'une instance de la classe PropertyOptions avec la connexion PDO
    $propertyOption = new PropertyOptions($pdo);
    
    // Appel de la méthode updateById() pour mettre à jour l'option de propriété
    $result = $propertyOption->updateById($id, $name);
    
    // Vérifie si la mise à jour a réussi ou non
    if ($result) {
        $_SESSION["success"] = "L'option a été mise à jour";
    } else {
        $_SESSION["error"] = "Erreur de la mise à jour";
    }
    
    // Redirection vers la page de listing des options de propriété
    header("Location: /immobilis/pages/admin/propertyOptions/index.php");
}
?>
