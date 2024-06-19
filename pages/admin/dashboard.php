<?php
// Définit le titre de la page
$title = "Tableau de bord";

// Inclut le fichier d'en-tête qui contient la structure HTML de l'en-tête de la page
require "../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Inclut la barre de navigation spécifique à l'interface d'administration
require "../components/navbar_admin.php";
?>

<div class="container p-4">
    <?php require "../components/flash.php";?>
    <h1>Tableau de bord</h1>

    <div class="row gap-2 mb-2">
        <!-- Card pour les biens immobiliers -->
        <div class="col card">
            <div class="card-header">Bien immobilier</div>
            <div class="card-body">
                <img style="width: 100%" src="public/assets/house.jpg" alt="">
            </div>
            <div class="card-footer">
                <!-- Liens pour ajouter un bien et voir tous les biens -->
                <a class="btn btn-success" href="pages/admin/properties/create.php">Ajouter un bien</a>
                <a class="btn btn-info" href="pages/admin/properties/index.php">Voir les Biens</a>
            </div>
        </div>

        <!-- Card pour les types de biens immobiliers -->
        <div class="col card">
            <div class="card-header">Types de Bien immobilier</div>
            <div class="card-body">
                <img style="width: 100%" src="public/assets/type_immo.jpg" alt="">
            </div>
            <div class="card-footer">
                <!-- Liens pour ajouter un type de bien et voir tous les types -->
                <a class="btn btn-success" href="pages/admin/propertyType/create.php">Ajouter un type</a>
                <a class="btn btn-info" href="pages/admin/propertyType/index.php">Voir les types</a>
            </div>
        </div>
    </div>

    <div class="row gap-2">
        <!-- Card pour les options immobilières -->
        <div class="col card">
            <div class="card-header">Options immobilieres</div>
            <div class="card-body">
                <img style="width: 100%" src="public/assets/option_immo.jpg" alt="">
            </div>
            <div class="card-footer">
                <!-- Liens pour ajouter une option et voir toutes les options -->
                <a class="btn btn-success" href="pages/admin/options/create.php">Ajouter une option</a>
                <a class="btn btn-info" href="pages/admin/options/index.php">Voir les options</a>
            </div>
        </div>

        <!-- Card pour les demandes de contact -->
        <div class="col card">
            <div class="card-header">Demande de contact</div>
            <div class="card-body">
                <img style="width: 100%;" src="public/assets/contact.jpg" alt="">
            </div>
            <div class="card-footer">
                <!-- Lien pour voir tous les messages de contact -->
                <a class="btn btn-info" href="pages/admin/contacts/index.php">Voir les messages</a>
            </div>
        </div>
    </div>

</div>

<?php
// Inclut le fichier de pied de page qui contient la structure HTML du pied de page de la page
require "../partials/footer.php";
?>







