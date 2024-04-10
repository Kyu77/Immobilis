<?php 
    $title = "Modifier une option";
    require "../../partials/header.php";
    if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
        header("Location: /immobilis/pages/admin/login.php");
    }
    require "../../components/navbar_admin.php";
    require "../../../database/connexion.php";
    require "../../../database/PropertyOptions.php";

    $pdo = Database::dbConnection();
    $propertyOption = new PropertyOptions($pdo);
    $id = intval(htmlentities($_GET["id"]));
    $pt = $propertyOption->findById($id);
?>


<main class="container p-4">
    <h1>Modifier l'option &#34;<?=$pt["name"]?>&#34;</h1>

    <form action="pages/admin/propertyOptions/update.php" method="POST">
        <?php $value=$pt["name"]; $name="name"; $label="Nom de l'option du bien"; require "../../components/input.php"?>
        <?php $value=$pt["id"]; $name="id"; $type="hidden"; $label=""; require "../../components/input.php"?>
        <button class="btn btn-success">Modifier</button>
    </form>
</main>

<?php
    require "../../partials/footer.php";
?>