<?php
session_start();
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
}
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
};


if(!empty($_POST) && isset($_POST["id"])) {
    $id = intval(htmlentities($_POST["id"]));

    require "../../../database/connexion.php";
    require "../../../database/properties.php";

    $pdo = Database::dbConnection();
    $property = new Property($pdo);
    // recuperer le bien par son id
    if ($property->getPropertyById($id)) {
    // extraire les chemins des images

    $imagesPaths = $property->getImagesProperties();

    $imagesPath = $property['image'];
    foreach ($cheminImage as $ci) {
        unlink($ci);
    }
    // les passer en arg a la fonction unlink
    $property->deleteProperty($id, $imagesPaths);

    // supprimer l'adresse du bien 
    $addressId = $property['address_id']; 
    // supprimer les option du bien 
    $optionsIds = json_decode($property['option_ids']);

    // supprimer le bien
    $deleteResult = $property->deleteProperty($id);


    if($result) {
        $_SESSION["success"] = "le bien  a été supprime";
    }
    else {
        $_SESSION["error"] = "erreur lors de la suppression";
    }

    header("Location: /immobilis/pages/admin/properties/index.php");
}