<?php
$title = "Ajouter un type de bien";

// Inclusion du fichier d'en-tête contenant les balises <head> et le titre de la page
require "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Inclusion du composant de navigation pour l'interface d'administration
require "../../components/navbar_admin.php";
?>

<main class="container p-4">
    <?php require "../../components/flash.php"; ?>
    <!-- Affiche les messages flash qui peuvent avoir été définis lors des opérations précédentes -->

    <h1>Ajouter un type de bien</h1>

    <form action="pages/admin/propertyType/store.php" method="POST">
        <?php $name = "name"; $label = "Nom du type de bien"; require "../../components/Input.php"; ?>
        <!-- Inclut un composant d'entrée pour saisir le nom du type de bien -->

        <button class="btn btn-success">Ajouter</button>
        <!-- Bouton pour soumettre le formulaire -->
    </form>
</main>

<?php
// Inclusion du fichier de pied de page
require "../../partials/footer.php";
?>


