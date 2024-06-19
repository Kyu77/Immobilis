<?php 
// Définit le titre de la page
$title = "Ajouter un bien";

// Inclut le fichier d'en-tête de la page
require "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Inclut le composant de la barre de navigation pour les utilisateurs administrateurs
require "../../components/navbar_admin.php";

// Inclut les fichiers nécessaires pour la connexion à la base de données et les manipulations de données
require "../../../database/connexion.php";
require "../../../database/Option.php";
require "../../../database/PropertyType.php";

// Établit la connexion à la base de données
$pdo = Database::dbConnection();

// Instancie les classes Option et PropertyType pour interagir avec les tables correspondantes
$option = new Option($pdo);
$propertyType = new PropertyType($pdo);

// Récupère toutes les options disponibles et tous les types de biens depuis la base de données
$options = $option->findAll();
$propertyTypes = $propertyType->findAll();
?>

<main class="container p-4">
    <?php require "../../components/flash.php";?>
    <h1>Ajouter un bien</h1>

    <form action="pages/admin/properties/store.php" method="POST">
        <div class="row">
            <div class="col">
                <?php $name="title"; $label="Titre d'un bien"; require "../../components/input.php"?>
                <?php $name="price"; $label="Prix"; $type="number"; require "../../components/input.php"?>
                <?php $name="rooms"; $label="Nombre de chambres"; $type="number"; require "../../components/input.php"?>
                <?php $name="floor"; $label="Étage"; $type="number"; require "../../components/input.php"?>
                <?php $name="bedrooms"; $label="Nombre de chambres à coucher"; $type="number"; require "../../components/input.php"?>
                <?php $name="bathrooms"; $label="Nombre de salles de bain"; $type="number"; require "../../components/input.php"?>
                <?php $name="images"; $type="file"; $label="Images"; $multiple=true; require "../../components/input.php"?>
                <?php $name="surface"; $type="number"; $label="Surface"; require "../../components/input.php"?>
            </div>
            <div class="col">
                <?php $name="number"; $type="number"; $label="Numéro"; require "../../components/input.php"?>
                <?php $name="street"; $type="text"; $label="Rue"; require "../../components/input.php"?>
                <?php $name="city"; $type="text"; $label="Ville"; require "../../components/input.php"?>
                <?php $name="zipcode"; $type="text"; $label="Code postal"; require "../../components/input.php"?>
                <?php $name="description"; $type="textarea"; $label="Description"; require "../../components/input.php"?>
                <?php $name="type"; $multiple=false; $label="Type de bien"; $value=$propertyTypes; require "../../components/Select.php"?>
                <?php $name="options[]"; $multiple=true; $label="Options"; $value=$options; require "../../components/Select.php"?>
            </div>
        </div>
        <button class="btn btn-success">Ajouter</button>
    </form>
</main>

<?php
// Inclut le fichier du pied de page
require "../../partials/footer.php";
?>
