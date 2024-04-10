<?php
session_start();
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
}
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: /immobilis/pages/admin/login.php");
};

if(!empty($_POST) && isset($_POST["name"]) && isset($_POST["id"])){
    $id = intval(htmlentities($_POST["id"]));
    $name = htmlentities($_POST["name"]);
    require "../../../database/connexion.php";
    require "../../../database/PropertyOptions.php";
    $pdo = Database::dbConnection();
    $propertyOption = new PropertyOptions($pdo);
    $result = $propertyOption->updateById($id,$name);
    if($result){
        $_SESSION["success"] = "L'option a été mis à jour";
    }
    else{
        $_SESSION["error"] = "Erreur de la mise à jour";
    }
    header("Location: /immobilis/pages/admin/propertyOptions/index.php");
}
?>