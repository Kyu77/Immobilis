<?php
$title = "Listing des messages";
require "../../partials/header.php";
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
}
require "../../components/navbar_admin.php";
require "../../../database/Contact.php";
require "../../../database/connexion.php";
$pdo = Database::dbConnection();
$contacts = new Contact($pdo);
$contacts =  $contacts->findAll();

?>


<main class="container p-4">
        <?php require "../../components/flash.php"?>
      <h1 class="text-center">Listing des messages</h1>

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
            <?php  foreach ($contacts as $c): ?>
                    <tr>
                        <td><?= $c["lastname"] ?></td>
                        <td><?= $c["firstname"] ?></td>
                        <td><?= $c["email"] ?></td>
                        <td><?= $c["message"] ?></td>
                        <td>
                            <a href="pages/properties/show.php?id=<?=$c["property_id"]?>">Voir le bien</a>
                            <form action="pages/admin/contacts/destroy.php" method="post">
                                <input type="hidden" value="<?=$c["id"]?>" name="id">
                                <button class="nav-link text-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
            <?php endforeach; ?>

            </tbody>

        </table>

</main>



<?php
require "../../partials/footer.php"; ?>