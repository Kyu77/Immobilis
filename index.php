<?php
$title = "Immobilis votre agent immobilier";

// Inclusion des fichiers nécessaires
require "pages/partials/header.php";
require "pages/components/navbar.php";
require "database/connexion.php";
require "database/Admin.php";
require "database/Property.php";

// Connexion à la base de données
$pdo = Database::dbConnection();

// Création d'un administrateur si aucun n'existe encore
$admin = new Admin($pdo);
if (count($admin->getAdmins()) === 0) {
    $admin->createAdmin();
}

// Récupération de tous les biens immobiliers
$property = new Property($pdo);
$properties = $property->findAll();
?>

<div class="container">
    <?php require "pages/components/flash.php"; ?>
    <h1 class="text-center">Nos biens immobiliers</h1>
</div>

<div class="d-flex flex-wrap gap-5 justify-content-center my-5">
    <?php foreach ($properties as $p): ?>
        <div class="card" style="width: 20rem">
            <img src="public/<?= json_decode($p["images"])[0] ?>" alt="">
            <div class="card-body">
                <h2><?= $p["title"] ?></h2>
                <span class="badge bg-secondary"><?= $p["price"] ?>€</span>
                <span class="badge bg-secondary"><?= $p["name"] ?></span>
                <span class="badge bg-secondary"><?= $p["city"] ?></span>
            </div>
            <div class="card-footer">
                <a class="btn btn-outline-success" href="pages/properties/show.php?id=<?= $p["id"] ?>">Voir le bien</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require "./pages/partials/footer.php"; ?>
