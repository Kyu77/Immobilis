<?php
$title = "Ajouter un bien";
require  "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

require "../../components/navbar_admin.php";

// Inclusions des fichiers de connexion à la base de données et des classes Option et PropertyType
require "../../../database/connexion.php";
require "../../../database/Option.php";
require "../../../database/PropertyType.php";

$pdo = Database::dbConnection(); // Connexion à la base de données via la méthode dbConnection
$option = new  Option($pdo); // Instanciation de la classe Option avec la connexion PDO établie
$propertyType = new PropertyType($pdo); // Instanciation de la classe PropertyType avec la connexion PDO établie

$options = $option->findAll(); // Récupération de toutes les options disponibles
$propertyTypes = $propertyType->findAll(); // Récupération de tous les types de biens disponibles
?>


<main class="container p-4">
    <?php require "../../components/flash.php"; ?> <!-- Inclusion du composant flash pour afficher les messages -->

    <h1>Ajouter un bien</h1>

    <form action="pages/admin/properties/store.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <!-- Champs d'entrée pour les informations principales de la propriété -->
                <?php $name="title"; $label="Titre du bien"; require "../../components/Input.php"?>
                <?php $name="price"; $label="Prix"; $type="number"; require "../../components/Input.php"?>
                <?php $name="rooms"; $label="Nombre de pièces"; $type="number"; require "../../components/Input.php"?>
                <?php $name="floor"; $label="Étage"; $type="number"; require "../../components/Input.php"?>
                <?php $name="bedrooms"; $label="Nombre de chambres à coucher"; $type="number"; require "../../components/Input.php"?>
                <?php $name="bathrooms"; $label="Nombre de salles de bains"; $type="number"; require "../../components/Input.php"?>
                <?php $name="images[]"; $type="file"; $multiple=true; $label="Images"; require "../../components/Input.php"?>
                <?php $name="surface"; $type="number"; $label="Surface"; require "../../components/Input.php"?>
            </div>
            <div class="col">
                <!-- Champs d'entrée pour l'adresse et la description de la propriété -->
                <?php $name="number"; $type="number"; $label="Numéro"; require "../../components/Input.php"?>
                <?php $name="street"; $type="text"; $label="Rue"; require "../../components/Input.php"?>
                <?php $name="city"; $type="text"; $label="Ville"; require "../../components/Input.php"?>
                <?php $name="zipcode"; $type="text"; $label="Code postal"; require "../../components/Input.php"?>
                <?php $name="description"; $type="textarea"; $label="Description"; require "../../components/Input.php"?>
                
                <!-- Sélection du type de bien à partir des options disponibles -->
                <?php $name="type"; $multiple=false; $label="Type de bien"; $value=$propertyTypes; require "../../components/Select.php"?>
                
                <!-- Sélection des options disponibles pour la propriété -->
                <?php $name="options[]"; $multiple=true; $label="Options"; $value=$options; require "../../components/Select.php"?>
            </div>
        </div>

        <button class="btn btn-success">Ajouter</button>
    </form>
</main>

<?php
require  "../../partials/footer.php";
?>

