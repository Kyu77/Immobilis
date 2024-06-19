<?php 
// Définition du titre de la page
$title = "Liste des options de bien";
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
// Récupération de toutes les options de propriété
$propertyOptions = $propertyOption->findAll();
?>

<main class="container p-4">
    <h1 class="text-center">Listing des options</h1>
    <?php require "../../components/flash.php";?>
    <table class="table">
        <thead>
            <tr>
                <th>Nom de l'Option</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($propertyOptions as $o):?>
                <tr>
                    <td><?= $o["name"]?></td>
                    <td>
                        <a href="pages/admin/propertyOptions/edit.php?id=<?=$o["id"]?>" class="nav-link text-info">Modifier</a>
                        <form action="pages/admin/propertyOptions/destroy.php" method="post">
                            <input type="hidden" value="<?=$o["id"]?>" name="id" autofocus>
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
