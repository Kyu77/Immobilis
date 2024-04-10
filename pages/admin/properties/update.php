<?php
session_start();
if($_SESSION["connected"] !== true || !isset($_SESSION["connected"])){
    header("Location: /immobilis/pages/admin/login.php");
}
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /immobilis/pages/admin/login.php");
};
var_dump($_POST);
if(!empty($_POST)
 && isset($_POST["title"])
 && isset($_POST["property_id"])
  && isset($_POST["price"])
   && isset($_POST["rooms"])
    && isset($_POST["floor"])
     && isset($_POST["bedrooms"])
      && isset($_POST["bathrooms"]) 
      && isset($_POST["images"])
       && isset($_POST["surface"])
        && isset($_POST["number"])
        && isset($_POST["street"])
         && isset($_POST["city"])
          && isset($_POST["zipcode"]) 
          && isset($_POST["description"])) {

            $id = intval(htmlentities($_POST["property_id"]));
            $title = htmlentities($_POST["title"]);
            $price = intval($_POST["price"]);
            $rooms = intval($_POST["rooms"]);
            $floor = intval($_POST["floor"]);
            $bedrooms = intval($_POST["bedrooms"]);
            $bathrooms = intval($_POST["bathrooms"]);
            $surface = intval($_POST["surface"]);
            $description = htmlentities($_POST["description"]);
            $number = intval($_POST["number"]);
            $street = htmlentities($_POST["street"]);
            $city = htmlentities($_POST["city"]);
            $zipcode = htmlentities($_POST["zipcode"]);
            require  "../../../database/connexion.php";
            require  "../../../database/properties.php";
            $pdo = Database::dbConnection();
            $properties = new properties($pdo);
            $result = $properties->updateById($id, $name, $title, $price, $rooms, $floor, $bedrooms, $surface, $description, $bathrooms, $images, $number, $street, $city, $zipcode );
           if($result) {
               $_SESSION["success"] = "Le bien à été mis a jour";
           }
           else {
               $_SESSION["error"] = "Erreur lors de la mise a jour";
           }

           header("Location: /immobilis/pages/admin/properties/index.php");
}