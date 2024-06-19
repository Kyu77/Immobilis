<?php
session_start();

// Vérifie si la méthode de requête est POST
$method = $_SERVER["REQUEST_METHOD"];
if ($method !== "POST") {
    header("Location: /immobilis/contact.php"); // Redirige vers une page si la méthode n'est pas POST
    header("Location: /immobilis/contact_menu_principal.php"); // Redirige vers une autre page (note : seul le dernier header sera pris en compte)
    // Cette partie du code n'aura pas d'effet pratique car deux headers Location ne peuvent pas être envoyés simultanément.
}

// Vérifie si le formulaire a été soumis et que les champs requis sont présents
if (!empty($_POST) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['message'])) {
    require "../../database/Property.php";
    require "../../database/connexion.php";
    
    // Connexion à la base de données
    $pdo = Database::dbConnection();
    $property = new Property($pdo);

    // Récupération des données du formulaire
    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $email = htmlentities($_POST['email']);
    $message = htmlentities($_POST['message']);
    $propertyId = intval($_POST['property_id']);

    // Appel de la méthode contact de la classe Property pour enregistrer le message de contact
    $success = $property->contact($firstname, $lastname, $email, $message, $propertyId);

    // Traitement après l'envoi du message
    if ($success) {
        $_SESSION["success"] = "Votre message a bien été pris en compte";

        // Configuration des paramètres pour l'envoi de mail (incomplète)
        ini_set("smtp_port", 1025); // Configuration du port SMTP
        ini_set("sendmail_from", "immobilis@noreply.com"); // Adresse email de l'expéditeur

        // En-têtes du mail (incomplète)
        $headers[] = 'Content-type:text/html; charset=iso-8859-1';

        // Envoi du mail de confirmation (incomplète)
        mail($email, "Demande contact", "<h1>Merci de nous avoir contacté</h1><br>Votre message a bien été pris en compte");

    } else {
        $_SESSION["error"] = "Erreur lors de l'envoi de votre message";
    }

    // Redirection vers la page d'accueil après traitement du formulaire
    header("Location: /immobilis/index.php");
}
?>
