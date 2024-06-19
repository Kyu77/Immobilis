<?php 
// Démarrage de la session PHP
session_start();

// Vérification de la connexion de l'utilisateur
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    // Si l'utilisateur n'est pas connecté ou si la variable de session n'existe pas, redirection vers la page de connexion
    header("Location: /immobilis/pages/admin/login.php");  
}

// Vérification de la méthode de requête HTTP (doit être POST)
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    // Si la méthode de requête n'est pas POST, redirection vers la page de connexion
    header("Location: /immobilis/pages/admin/login.php");
};

// Vérification si le formulaire a été soumis et si l'ID du contact à supprimer est présent
if(!empty($_POST) && isset($_POST["id"])){
    // Récupération et sécurisation de l'ID du contact à supprimer
    $id = intval(htmlentities($_POST["id"]));
    
    // Inclusion du fichier de connexion à la base de données et de la classe Contact
    require "../../../database/connexion.php";
    require "../../../database/Contact.php";

    // Connexion à la base de données
    $pdo = Database::dbConnection();
    
    // Instanciation de la classe Contact avec la connexion PDO établie
    $contact = new Contact($pdo);

    // Appel de la méthode deleteById pour supprimer le contact
    $result = $contact->deleteById($id);
    
    // Vérification du résultat de la suppression
    if($result){
        // Si la suppression a réussi, définir un message de succès dans la session
        $_SESSION["success"] = "Le message a été supprimé";
    }
    else{
        // Si la suppression a échoué, définir un message d'erreur dans la session
        $_SESSION["error"] = "Erreur lors de la suppression";
    }

    // Redirection vers la page de gestion des contacts après traitement
    header("Location: /immobilis/pages/admin/contacts/index.php");
}
?>
