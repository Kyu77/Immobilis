<?php 
// Définition du titre de la page
$title = "Modifier une option";
// Inclusion du fichier d'en-tête
require "../../partials/header.php";

// Vérification si l'utilisateur est connecté, sinon redirection vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrêt de l'exécution du script après la redirection
}

// Inclusion du composant de barre de navigation pour l'administration
require "../../components/navbar_admin.php";

// Inclusion des fichiers de connexion à la base de données et du modèle pour les options de propriété
require "../../../database/connexion.php";
require "../../../database/PropertyOptions.php";

// Connexion à la base de données
$pdo = Database::dbConnection();
// Création d'une instance de la classe PropertyOptions avec la connexion PDO
$propertyOption = new PropertyOptions($pdo);

// Récupération de l'identifiant de l'option à modifier depuis les paramètres GET sécurisés
$id = intval(htmlentities($_GET["id"]));
// Recherche de l'option de propriété par son identifiant
$pt = $propertyOption->findById($id);
?>

<main class="container p-4">
    <h1>Modifier l'option "<?=$pt["name"]?>"</h1>

    <form action="pages/admin/propertyOptions/update.php" method="POST">
        <?php 
        // Champ pour le nom de l'option de propriété avec sa valeur préremplie
        $value = $pt["name"]; 
        $name = "name"; 
        $label = "Nom de l'option du bien"; 
        require "../../components/input.php";
        ?>
        <?php 
        // Champ caché pour l'identifiant de l'option de propriété
        $value = $pt["id"]; 
        $name = "id"; 
        $type = "hidden"; 
        $label = ""; 
        require "../../components/input.php";
        ?>
        <button class="btn btn-success">Modifier</button>
    </form>
</main>

<?php
// Inclusion du fichier de pied de page
require "../../partials/footer.php";
?>
