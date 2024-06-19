<?php
// Définition du titre de la page
$title = "Ajouter l'option d'un bien";

// Inclusion du fichier d'en-tête (header.php) qui contient les balises <head> et le début de la page HTML
require "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Inclusion de la barre de navigation pour l'administration
require "../../components/navbar_admin.php";
?>

<main class="container p-4">
    <?php require "../../components/flash.php";?>
    <!-- Affiche les messages flash -->

    <h1>Ajouter l'option d'un bien</h1>

    <!-- Formulaire pour ajouter une nouvelle option de bien -->
    <form action="pages/admin/propertyOptions/store.php" method="POST">
        <?php $name="name"; $label="Nom de l'option du bien"; require "../../components/input.php"?>
        <!-- Inclusion du composant "input.php" avec les paramètres $name et $label -->

        <button class="btn btn-success">Ajouter</button>
        <!-- Bouton pour soumettre le formulaire -->
    </form>
</main>

<?php
// Inclusion du fichier de pied de page (footer.php) qui contient la fermeture des balises HTML et les scripts JavaScript
require "../../partials/footer.php"
?>
