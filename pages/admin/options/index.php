<?php
$title = "Listing type de bien"; // Titre de la page
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
$options =  $option->findAll(); // Récupération de toutes les options disponibles
?>

<main class="container p-4">
    <?php require "../../components/flash.php"?> <!-- Inclusion du composant flash pour afficher les messages -->
    <h1 class="text-center">L'ensemble des options</h1> <!-- Titre principal -->

    <table class="table border">
        <thead>
            <tr>
                <th>Nom de l'option</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($options as $o): ?> <!-- Boucle pour afficher chaque option -->
                <tr>
                    <td><?= $o["name"] ?></td> <!-- Affichage du nom de l'option -->
                    <td>
                        <a class="nav-link text-info" href="pages/admin/options/edit.php?id=<?=$o["id"]?>">Modifier</a>
                        <!-- Lien pour modifier l'option, pointant vers la page d'édition avec l'ID de l'option -->
                        <form action="pages/admin/options/destroy.php" method="post">
                            <input type="hidden" value="<?=$o["id"]?>" name="id">
                            <!-- Formulaire pour supprimer l'option, avec un champ caché pour l'ID de l'option -->
                            <button class="nav-link text-danger">Supprimer</button> <!-- Bouton de suppression -->
                        </form>
                    </td>
                </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</main>

<?php
require "../../partials/footer.php"; // Inclusion du fichier de pied de page HTML
?>
