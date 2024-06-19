<?php
$title = "Détails du bien";
// Import du header
require "../partials/header.php";
require  "../components/navbar.php";

// Vérifie si l'identifiant du bien est présent dans la requête GET
if(!empty($_GET) && isset($_GET["id"])) {
    require "../../database/connexion.php";
    require "../../database/Property.php";

    // Récupère l'identifiant du bien depuis la requête GET
    $id = intval($_GET["id"]);
    $pdo = Database::dbConnection();
    $property =  new Property($pdo);
    // Récupère les détails du bien avec l'identifiant donné
    $p = json_decode($property->findById($id)["property"], true);
}
?>
<div class="container">
    <h1 class="text-center"><?= $p["title"] ?></h1>
</div>
<div id="carouselExample" class="carousel slide">
    <div class="carousel-inner mx-auto" style="width: 1000px;">
        <?php foreach($p['images'] as $index => $imagePath) : ?>
        <div class="carousel-item <?= $index == 0 ? 'active' : '' ?> w-500">
            <img src="public/<?= $imagePath ?>" class="d-block w-100" alt="...">
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Description du bien
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p><?= $p["description"] ?></p>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Informations complémentaires
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p>Prix: <?= $p["price"] ?> € </p>
                <p>Nombre de pièce(s): <?= $p["rooms"] ?></p>
                <p>Etage(s): <?= $p["floor"] ?></p>
                <p>Surface: <?= $p["surface"] ?> m2</p>
                <p>Ville: <?= $p["address"]["city"] ?></p>
            </div>
        </div>
    </div>
</div>

<?php if(!isset($_SESSION["connected"])) : ?>
<section>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="pages/properties/contact.php?id=<?= $p["id"] ?>">
                <h2> Nous contacter pour ce bien</h2>
            </a>
        </li>
    </ul>
</section>
<?php endif; ?>
