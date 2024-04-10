<?php 
    $title = "Liste des options de bien";
    require "../../partials/header.php";
    if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
        header("Location: /immobilis/pages/admin/login.php");
    }
    require "../../components/navbar_admin.php";
    require "../../../database/connexion.php";
    require "../../../database/PropertyOptions.php";
    $pdo = Database::dbConnection();
    $propertyOption = new PropertyOptions($pdo);
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
    require "../../partials/footer.php";
?>