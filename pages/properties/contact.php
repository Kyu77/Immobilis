<?php
$title = "Détails du bien";
// Import du header
require "../partials/header.php";
require  "../components/navbar.php";

if(!empty($_GET) && isset($_GET["id"]))
require "../../database/connexion.php";
require "../../database/Property.php";
$id = intval($_GET['id']);
?>



<section>
    <h3> Nous contacter pour ce bien</h3> 
    <form action="pages/properties/handle_contact.php" method="post" class="w-35 mx-auto">
         <input type="hidden"  name="property_id" value="<?=$id?>">
        <?php $label="Prénom"; $name="firstname"; require "../components/Input.php"?>
        <?php $label="Nom"; $name="lastname"; require "../components/Input.php"?>
        <?php $label="Email"; $name="email"; require "../components/Input.php"?>
        <?php $label="Votre message"; $name="message";$type="textarea";  require "../components/Input.php"?>
        <button class="btn btn-outline-primary">Envoyer</button>
    </form>
  </section>