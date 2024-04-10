<?php
session_start();
$method = $_SERVER["REQUEST_METHOD"];
if($method !== "POST" ) {
    header("Location: /immobilis/contact.php");
    header("Location: /immobilis/contact_menu_principal.php");
}



if(!empty($_POST) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['message']) ){
    require "../../database/Property.php";
    require "../../database/connexion.php";
    $pdo = Database::dbConnection();
    $property=new Property($pdo);

    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $email = htmlentities($_POST['email']);
    $message = htmlentities($_POST['message']);
    $propertyId = intval($_POST['property_id']);

    $sucess = $property ->contact($firstname, $lastname, $email, $message, $propertyId);

    if($sucess){
        $_SESSION["success"] = "Votre message a bien été pris en compte";
        ini_set("smtp_port",1025);
        ini_set("sendmail_from","immobilis@noreply.com");
        $headers[]= 'Content-type:text/html; charset=iso-8859-1';
        mail($email,"Demande contact","<h1>Merci de nous avoir contacter</h1> <br> Votre message à bien été pris en compte");
    }
    else{
        $_SESSION["error"] = "Erreur lors de l'envoie de votre message";
    }

    header("Location: /immobilis/index.php");
}
?>