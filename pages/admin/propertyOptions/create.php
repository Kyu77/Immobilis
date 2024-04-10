<?php 
$title = "Ajouter l'option d'un bien";
require "../../partials/header.php";
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
}
require "../../components/navbar_admin.php";
?>

<main class="container p-4">
    <?php require "../../components/flash.php";?>
    <h1>Ajouter l'option d'un bien</h1>

    <form action="pages/admin/propertyOptions/store.php" method="POST">
        <?php $name="name"; $label="Nom de l'option du bien"; require "../../components/input.php"?>
        <button class="btn btn-success">Ajouter</button>
    </form>
</main>

<?php
require "../../partials/footer.php"
?>