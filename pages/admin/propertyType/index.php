<?php
// Définition du titre de la page
$title = "Listing type de bien";

// Inclusion du fichier d'en-tête de la page
require "../../partials/header.php";

// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page de connexion
if ($_SESSION["connected"] !== true || !isset($_SESSION["connected"])) {
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrête l'exécution du script après la redirection
}

// Inclusion de la barre de navigation pour l'administration
require "../../components/navbar_admin.php";

// Inclusions des fichiers de connexion à la base de données et de la classe PropertyType
require "../../../database/connexion.php";
require "../../../database/PropertyType.php";

// Établit la connexion à la base de données
$pdo = Database::dbConnection();

// Instanciation de la classe PropertyType pour gérer les types de biens
$propertyType = new PropertyType($pdo);

// Récupère tous les types de biens à partir de la base de données
$propertyTypes =  $propertyType->findAll();
?>


<main class="container p-4">
    <?php require "../../components/flash.php";?>
    <h1 class="text-center">Listing type de bien</h1>

    <table class="table border">
        <thead>
            <tr>
                <th>Type de bien</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($propertyTypes as $pt): ?>
            <tr>
                <td><?= $pt["name"] ?></td>
                <td>
                    <a class="nav-link text-info" href="pages/admin/propertyType/edit.php?id=<?=$pt["id"]?>">Modifier</a>
                    <form action="pages/admin/propertyType/destroy.php" method="post">
                        <input type="hidden" value="<?=$pt["id"]?>" name="id">
                        <button class="nav-link text-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</main>

<?php
// Inclusion du fichier de pied de page
require "../../partials/footer.php";
?>

