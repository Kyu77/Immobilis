<?php 
session_start();

// Vérification si l'utilisateur est connecté, sinon redirection vers la page de connexion
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérification que la requête est de type POST, sinon redirection vers la page de connexion
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérification que les données POST nécessaires sont présentes
if(!empty($_POST) && isset($_POST["id"])){
    $id = intval(htmlentities($_POST["id"]));
    
    // Inclusion du fichier de connexion à la base de données et de la classe Property
    require "../../../database/connexion.php";
    require "../../../database/Property.php";

    // Connexion à la base de données
    $pdo = Database::dbConnection();
    $Property = new Property($pdo);

    // Suppression des images associées à la propriété
    $images = json_decode($Property->selectImages($id)["images"]); // Récupération des images sous forme de tableau
    foreach ($images as $i) {
        unlink("../../../public/" . $i); // Suppression physique des fichiers d'images depuis le dossier public
    }

    // Suppression des liaisons entre la propriété et ses options
    $options_result = $Property->deletePropertiesOptionsById($id);

    // Suppression de la propriété et de son adresse
    $property_address_result = $Property->deletePropertyAndAddressById($id);

    // Vérification si les opérations de suppression ont réussi
    if($options_result && $property_address_result){
        $_SESSION["success"] = "La propriété a été supprimée avec succès";
    }
    else{
        $_SESSION["error"] = "Erreur lors de la suppression de la propriété";
    }

    // Redirection vers la page principale des propriétés après l'opération
    header("Location: /immobilis/pages/admin/properties/index.php");
}
?>
