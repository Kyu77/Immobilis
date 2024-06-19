<?php
session_start();

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Vérifie si la requête HTTP est de type POST, sinon redirige également vers la page de connexion
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Affiche le contenu de $_POST et arrête l'exécution du script
var_dump($_POST);
die;

// Vérifie si $_POST contient des données nécessaires pour la mise à jour de la propriété
if (!empty($_POST)) {
    // Récupération des données du formulaire et sécurisation
    $id = intval(htmlentities($_POST["property_id"]));
    $title = htmlentities($_POST["name"]);
    $price = htmlentities($_POST["price"]);
    $rooms = htmlentities($_POST["rooms"]);
    $floor = htmlentities($_POST["name"]); // Problème potentiel : $floor devrait être récupéré de $_POST["floor"]
    $bedrooms = htmlentities($_POST["bedrooms"]);
    $bathrooms = htmlentities($_POST["bathrooms"]);
    $surface = htmlentities($_POST["surface"]);
    $description = htmlentities($_POST["description"]);
    $type = htmlentities($_POST["type"]);
    $number = htmlentities($_POST["number"]);
    $city = htmlentities($_POST["city"]);
    $street = htmlentities($_POST["street"]);
    $zipcode = htmlentities($_POST["zipcode"]);
    $options = $_POST["options"];
    $images = $_POST["images"];

    // Inclusion des fichiers de connexion et des classes nécessaires
    require "../../../database/connexion.php";
    require "../../../database/Property.php";
    require "../../../database/Address.php";
    require "../../../database/PropertyOption.php";

    // Connexion à la base de données
    $pdo = Database::dbConnection();

    // Instanciation des objets pour gérer les données
    $Property = new Property($pdo);
    $address = new Address($pdo);
    $propertyOption = new PropertyOption($pdo);

    // Mise à jour des options de propriété si elles sont présentes dans $_POST["options"]
    if ($options) {
        $Property->deletePropertiesOptionsById($id); // Supprime les options existantes pour cette propriété
        $optionsIds = [];
        foreach ($_POST["options"] as $o) {
            array_push($optionsIds, intval($o));
        }
        $propertyOption->store($id, $optionsIds); // Enregistre les nouvelles options pour cette propriété
    }

    // Mise à jour des images si elles sont présentes dans $_POST["images"]
    if ($images) {
        // Suppression des anciennes images liées à cette propriété
        $image_del = json_decode($Property->selectImages($id)["images"]);
        foreach ($image_del as $i) {
            unlink("../../../public/" . $i);
        }

        // Ajout des nouvelles images téléchargées
        $fileNames = $_FILES["images"]["name"];
        $tmpNames = $_FILES["images"]["tmp_name"];
        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        for ($i = 0; $i < count($fileNames); $i++) {
            $fileName = uniqid() . basename($fileNames[$i]);
            $filePath = "storage/property/$fileName";
            array_push($images, $filePath);
            move_uploaded_file($tmpNames[$i], "$documentRoot/immobilis/public/$filePath");
        }
        $Property->updateImages($id, json_encode($images)); // Met à jour les images de la propriété dans la base de données
    }

    // Mise à jour de l'adresse de la propriété
    $address->update($id, $street, $city, $zipcode, $number);

    // Mise à jour des autres informations de la propriété
    $result = $Property->update(
        $title,
        $price,
        $surface,
        $rooms,
        $floor, 
        $bedrooms,
        $bathrooms,
        $description,
        $typeId, 
        $addressId
    );

    // Gestion des messages de succès ou d'erreur
    if ($result) {
        $_SESSION["success"] = "La propriété a été mise à jour";
    } else {
        $_SESSION["error"] = "Erreur de la mise à jour";
    }

    // Redirection vers la page d'index des propriétés après la mise à jour
    header("Location: /immobilis/pages/admin/properties/index.php");
    exit; // Arrête l'exécution du script après la redirection
}
?>
