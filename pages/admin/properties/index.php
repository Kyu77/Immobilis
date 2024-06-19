<?php
$title = "Listing type de bien";
require "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

require "../../components/navbar_admin.php";

// Inclusion du fichier de connexion à la base de données et de la classe Properties
require "../../../database/connexion.php";
require "../../../database/properties.php";

// Établit la connexion à la base de données
$pdo = Database::dbConnection();
$properties = new properties($pdo);

// Récupère toutes les propriétés
$properties =  $properties->findAll();
?>

<main class="container p-4">
    <?php require "../../components/flash.php"; ?>
    <h1 class="text-center">Listing de bien</h1>

    <table class="table border">
        <thead>
            <tr>
                <th>Bien immobiliers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($properties as $p): ?>
                <tr>
                    <td><?= $p["title"] ?></td>
                    <td>
                        <a class="nav-link text-info" href="pages/admin/properties/edit.php?id=<?= $p["id"] ?>">Modifier</a>
                        <form action="pages/admin/properties/destroy.php" method="post">
                            <input type="hidden" value="<?= $p["id"] ?>" name="id">
                            <button class="nav-link text-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</main>

<?php
require "../../partials/footer.php";
?>
