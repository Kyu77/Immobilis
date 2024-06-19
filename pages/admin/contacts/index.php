<?php
// Définition du titre de la page
$title = "Listing des messages";

// Inclusion du fichier d'en-tête (header.php) pour l'affichage commun
require "../../partials/header.php";

// Vérification de la connexion de l'utilisateur via la session
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    // Si l'utilisateur n'est pas connecté ou si la variable de session n'existe pas, redirection vers la page de connexion
    header("Location: /immobilis/pages/admin/login.php");
    exit; // Arrêt de l'exécution du script après la redirection
}

// Inclusion de la barre de navigation spécifique à l'administration
require "../../components/navbar_admin.php";

// Inclusion des fichiers de classe nécessaires pour la gestion des contacts et la connexion à la base de données
require "../../../database/Contact.php";
require "../../../database/connexion.php";

// Connexion à la base de données
$pdo = Database::dbConnection();

// Création d'une instance de la classe Contact avec la connexion PDO établie
$contacts = new Contact($pdo);

// Récupération de tous les contacts à partir de la base de données
$contacts =  $contacts->findAll();
?>

<main class="container p-4">
    <?php require "../../components/flash.php"; // Inclusion du composant pour afficher les messages flash ?>

    <h1 class="text-center">Ensemble des messages</h1>

    <table class="table border">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $c): ?>
                <tr>
                    <td><?= $c["lastname"] ?></td>
                    <td><?= $c["firstname"] ?></td>
                    <td><?= $c["email"] ?></td>
                    <td><?= $c["message"] ?></td>
                    <td>
                        <a href="pages/properties/show.php?id=<?= $c["property_id"] ?>">Voir le bien</a>
                        <form action="pages/admin/contacts/destroy.php" method="post">
                            <input type="hidden" value="<?= $c["id"] ?>" name="id">
                            <button class="nav-link text-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
// Inclusion du fichier de pied de page (footer.php) pour l'affichage commun
require "../../partials/footer.php";
?>
