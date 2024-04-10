<?php
$title = "Listing type de bien";
require "../../partials/header.php";
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
}
require "../../components/navbar_admin.php";

require "../../../database/connexion.php";
require "../../../database/properties.php";
$pdo = Database::dbConnection();
$properties = new properties($pdo);
$properties =  $properties->findAll();

?>


<main class="container p-4">
        <?php require "../../components/flash.php"?>
      <h1 class="text-center">Listing de bien</h1>

        <table class="table border">
            <thead>
                <tr>
                    <th>Bien immobiliers</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php  foreach ($properties as $p): ?>
                    <tr>
                        <td><?= $p["title"] ?></td>
                        <td>
                            <a class="nav-link text-info" href="pages/admin/properties/edit.php?id=<?=$p["id"]?>">Modifier</a>
                            <form action="pages/admin/properties/destroy.php" method="post">
                                <input type="hidden" value="<?=$p["id"]?>" name="id">
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

