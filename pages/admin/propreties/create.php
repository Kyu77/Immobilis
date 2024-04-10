<?php 
$title = "Ajouter un bien";
require "../../partials/header.php";
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
}
require "../../components/navbar_admin.php";

require "../../../database/connexion.php";
require "../../../database/Option.php";
require "../../../database/PropertyType.php";

$pdo = Database::dbConnection();
$option = new Option($pdo);
$propertyType = new PropertyType($pdo);

$options = $option->findAll();
$propertyTypes = $propertyType->findAll();

?>

<main class="container p-4">
    <?php require "../../components/flash.php";?>
    <h1>Ajouter un bien</h1>

    <form action="pages/admin/properties/store.php" method="POST">
        <div class="row">
            <div class="col">
                <?php $name="title"; $label="Titre un bien"; require "../../components/input.php"?>
                <?php $name="price"; $label="Prix"; $type="number"; require "../../components/input.php"?>
                <?php $name="rooms"; $label="Nombre de chambres"; $type="number"; require "../../components/input.php"?>
                <?php $name="floor"; $label="Etage"; $type="number"; require "../../components/input.php"?>
                <?php $name="bedrooms"; $label="Nombre de chambres à coucher"; $type="number"; require "../../components/input.php"?>
                <?php $name="bathrooms"; $label="Nombre de salle de bain"; $type="number"; require "../../components/input.php"?>
                <?php $name="images"; $type="file"; $label="images"; $multiple=true ; require "../../components/input.php"?>
                <?php $name="surface"; $type="number"; $label="Surface"; require "../../components/input.php"?>
                
            </div>
            <div class="col">
                <?php $name="number"; $type="number"; $label="Numero"; require "../../components/input.php"?>
                <?php $name="street"; $type="text"; $label="Rue"; require "../../components/input.php"?>
                <?php $name="city"; $type="text"; $label="Ville"; require "../../components/input.php"?>
                <?php $name="zip code"; $type="text"; $label="Code postal"; require "../../components/input.php"?>
                <?php $name="description"; $type="textarea"; $label="Description"; require "../../components/input.php"?>
                <?php $name="type"; $multiple=false ; $label="Type de bien"; $value=$propertyTypes; require "../../components/Select.php"?>
                <?php $name="options[]"; $multiple=true; $label="Options"; $value=$options; require "../../components/Select.php"?>

            </div>
        </div>
        <button class="btn btn-success">Ajouter</button>
    </form>
</main>

<?php
require "../../partials/footer.php"
?>