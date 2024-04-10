<?php 
session_start();
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");  
}
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: /immobilis/pages/admin/login.php");
};

if(!empty($_POST) && isset($_POST["id"])){
    $id = intval(htmlentities($_POST["id"]));
    require "../../../database/connexion.php";
    require "../../../database/propertyOptions.php";

    $pdo = Database::dbConnection();
    $propertyOption = new PropertyOptions($pdo);

    $result = $propertyOption->deleteById($id);
    
    if($result){
        $_SESSION["success"] = "L'option à été supprimé";
    }
    else{
        $_SESSION["error"] = "Erreur lors de la suppresion";
    }
    header("Location: /immobilis/pages/admin/propertyOptions/index.php");
}
?>
