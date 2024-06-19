<?php
// Définition du titre de la page
$title = "Modifier un type";

// Inclusion du fichier d'en-tête de page
require "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Inclusion de la barre de navigation pour l'administration
require  "../../components/navbar_admin.php";

// Inclusions des fichiers de connexion à la base de données et de la classe PropertyType
require "../../../database/connexion.php";
require "../../../database/PropertyType.php";

// Établit la connexion à la base de données
$pdo = Database::dbConnection();

// Instanciation de la classe PropertyType pour gérer les types de biens
$propertyType = new PropertyType($pdo);

// Récupère l'ID du type de bien à modifier depuis $_GET et le sécurise avec intval(htmlentities())
$id =  intval(htmlentities($_GET["id"]));

// Récupère les informations du type de bien à partir de son ID
$pt = $propertyType->findById($id);
?>

<main class="container p-4">
    <h1>Modifier le type <?= $pt["name"] ?></h1>

    <form action="pages/admin/propertyType/update.php" method="POST">
        <?php 
        // Champ d'entrée pour le nom du type de bien avec la valeur préremplie
        $value=$pt["name"];
        $name="name";
        $label="Nom du type de bien";
        require "../../components/Input.php";
        ?>
        
        <?php 
        // Champ d'entrée caché pour l'ID du type de bien
        $value=$pt["id"];
        $name="id";
        $type="hidden";
        $label="";
        require "../../components/Input.php";
        ?>
        
        <button class="btn btn-success">Modifier</button>
    </form>
</main>

<?php
// Inclusion du fichier de pied de page
require "../../partials/footer.php";
?>

