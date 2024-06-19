<?php
// Démarre la session
session_start();

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// TODO FORMULAIRE : Cette partie pourrait contenir le formulaire HTML pour l'ajout de biens immobiliers

// Vérifie si des données ont été soumises via POST
if (!empty($_POST)) {
    // Propriété
    $title = htmlentities($_POST["title"]);
    $price = intval($_POST["price"]);
    $rooms = intval($_POST["rooms"]);
    $floor = intval($_POST["floor"]);
    $bedrooms = intval($_POST["bedrooms"]);
    $bathrooms = intval($_POST["bathrooms"]);
    $surface = intval($_POST["surface"]);
    $description = htmlentities($_POST["description"]);
    $typeId = intval($_POST["type"]);
    $images = [];
    $optionsIds = [];

    // Adresse
    $number = intval($_POST["number"]);
    $street = htmlentities($_POST["street"]);
    $city = htmlentities($_POST["city"]);
    $zipcode = htmlentities($_POST["zipcode"]);

    // Conversion et ajout des identifiants des options dans le tableau optionsIds
    foreach ($_POST["options"] as $o) {
        array_push($optionsIds, intval($o));
    }

    // Gestion des images (stockage dans le serveur web)
    $fileNames = $_FILES["images"]["name"];
    $tmpNames = $_FILES["images"]["tmp_name"];
    $documentRoot = $_SERVER["DOCUMENT_ROOT"];

    // Parcours des fichiers téléchargés
    for ($i = 0; $i < count($fileNames); $i++) {
        $fileName = uniqid() . basename($fileNames[$i]);
        $filePath = "storage/property/$fileName";
        array_push($images, $filePath);
        $result = move_uploaded_file($tmpNames[$i], "$documentRoot/immobilis/public/$filePath");
        var_dump($result); // Débogage : vérifie si le téléchargement du fichier a réussi
    }

    // Inclusion des classes pour la gestion de la base de données
    require "../../../database/connexion.php";
    require "../../../database/Property.php";
    require "../../../database/Address.php";
    require "../../../database/PropertyOption.php";

    // Connexion à la base de données
    $pdo = Database::dbConnexion();

    // Instanciation des objets pour manipuler les données de la base de données
    $property = new Property($pdo);
    $address = new Address($pdo);
    $propertyOption = new PropertyOption($pdo);

    // Stockage de l'adresse et de la propriété dans la base de données
    $addressId = $address->store($number, $street, $city, $zipcode);
    $propertyId = $property->store(
        $title,
        $price,
        $surface,
        $rooms,
        $floor,
        $bedrooms,
        $bathrooms,
        $description,
        json_encode($images),
        $typeId,
        $addressId
    );

    // Stockage des options associées à la propriété
    $result = $propertyOption->store($propertyId, $optionsIds);

    // Gestion des messages de succès ou d'erreur
    if ($result) {
        $_SESSION["success"] = "Le bien immobilier a été ajouté";
    } else {
        $_SESSION["error"] = "Erreur lors de l'ajout";
    }

    // Redirection vers la page de création de biens immobiliers
    header("Location: /immobilis/pages/admin/properties/create.php");
    exit; // Arrête l'exécution du script après la redirection
}
?>
