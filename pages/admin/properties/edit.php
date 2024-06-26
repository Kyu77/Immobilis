<?php
$title = "Modifier un type";
require "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Termine l'exécution du script après la redirection
}

require  "../../components/navbar_admin.php";

// Inclut le fichier de connexion à la base de données et la classe Properties
require "../../../database/connexion.php";
require "../../../database/properties.php";

// Établit la connexion à la base de données
$pdo = Database::dbConnection();
$property = new properties($pdo);

// Récupère l'identifiant de la propriété à modifier depuis l'URL
$id =  intval(htmlentities($_GET["id"]));

// Récupère les données de la propriété à partir de son identifiant
$p = $property->findById($id);
?>

<main class="container p-4">
    <h1>Modifier le bien: <?= $p["title"] ?></h1>

    <form action="pages/admin/properties/update.php" method="POST">
        <div class="col">
            <?php $name="title"; $label="Titre du bien"; require "../../components/Input.php"?>
            <?php $name="price"; $label="Prix";  $type="number"; require "../../components/Input.php"?>
            <?php $name="rooms"; $label="Nombre de chambres";  $type="number"; require "../../components/Input.php"?>
            <?php $name="floor"; $label="Etage";  $type="number"; require "../../components/Input.php"?>
            <?php $name="bedrooms"; $label="Nombre de chambres a coucher";  $type="number"; require "../../components/Input.php"?>
            <?php $name="bathrooms"; $label="Nombre de salles de bains";  $type="number"; require "../../components/Input.php"?>
            <?php $name="images[]"; $type="file";  $multiple=true; $label="images"; require "../../components/Input.php"?>
            <?php $name="surface"; $type="number"; $label="Surface"; require "../../components/Input.php"?>
        </div>
        <div class="col">
            <?php $name="number"; $type="number"; $label="Numero"; require "../../components/Input.php"?>
            <?php $name="street"; $type="text"; $label="Rue"; require "../../components/Input.php"?>
            <?php $name="city"; $type="text"; $label="Ville"; require "../../components/Input.php"?>
            <?php $name="zipcode"; $type="text"; $label="Code postal"; require "../../components/Input.php"?>
            <?php $name="description"; $type="textarea"; $label="Description"; require "../../components/Input.php"?>
        </div>

        <?php $value=$p["id"]; $name="property_id"; $type="hidden"; $label=""; require "../../components/input.php"?>
        
        <button class="btn btn-success">Modifier</button>
    </form>
</main>

<?php
require "../../partials/footer.php";
?>

