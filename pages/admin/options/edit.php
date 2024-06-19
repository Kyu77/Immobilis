<?php
$title = "Modifier un type"; // Titre de la page
require "../../partials/header.php"; // Inclusion du fichier d'en-tête HTML

// Vérification de la connexion de l'utilisateur via la variable de session "connected"
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php"); // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    exit; // Arrêt de l'exécution du script après la redirection
}

require "../../components/navbar_admin.php"; // Inclusion de la barre de navigation pour l'administration

// Inclusion des fichiers de connexion à la base de données et de la classe Option
require "../../../database/connexion.php";
require "../../../database/Option.php";

$pdo = Database::dbConnection(); // Connexion à la base de données via la méthode dbConnection
$option = new Option($pdo); // Instanciation de la classe Option avec la connexion PDO établie

$id =  intval(htmlentities($_GET["id"])); // Récupération et sécurisation de l'ID de l'option à modifier depuis la query string
$o = $option->findById($id); // Appel de la méthode findById pour récupérer les informations de l'option spécifiée par son ID
?>

<main class="container p-4">
    <h1>Modifier l'option <?= $o["name"] ?></h1> <!-- Affichage du nom de l'option à modifier -->

    <form action="pages/admin/options/update.php" method="POST"> <!-- Formulaire de modification avec action vers le script de mise à jour -->
        <?php $value=$o["name"]; $name="name"; $label="Nom de l'option"; require "../../components/Input.php"?>
        <!-- Champ de saisie pour le nom de l'option, incluant un composant Input -->
        
        <?php $value=$o["id"]; $name="id"; $type="hidden"; $label=""; require "../../components/Input.php"?>
        <!-- Champ caché pour l'ID de l'option à modifier -->

        <button class="btn btn-success">Modifier</button> <!-- Bouton de soumission du formulaire -->
    </form>
</main>

<?php
require "../../partials/footer.php"; // Inclusion du fichier de pied de page HTML
?>
