<?php
// Définition du titre de la page
$title = "Ajouter Option";

// Inclusion du fichier d'en-tête (header.php) pour l'affichage commun
require  "../../partials/header.php";

// Vérification de la connexion de l'utilisateur via la session
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    // Si l'utilisateur n'est pas connecté ou si la variable de session n'existe pas, redirection vers la page de connexion
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrêt de l'exécution du script après la redirection
}

// Inclusion de la barre de navigation spécifique à l'administration
require "../../components/navbar_admin.php";
?>

<main class="container p-4">
    <?php  require "../../components/flash.php"; // Inclusion du composant pour afficher les messages flash ?>
    <h1>Ajouter Une option</h1>

    <form action="pages/admin/options/store.php" method="POST">
        <?php 
        $name = "name"; // Nom du champ de saisie
        $label = "Nom de l'option"; // Libellé du champ de saisie
        require "../../components/Input.php"; // Inclusion du composant Input qui génère un champ de saisie
        ?>
        <button class="btn btn-success">Ajouter</button> <!-- Bouton pour soumettre le formulaire -->
    </form>
</main>

<?php
// Inclusion du fichier de pied de page (footer.php) pour l'affichage commun
require  "../../partials/footer.php";
?>
