<?php
// Initialisation des variables avec des valeurs par défaut si elles ne sont pas déjà définies
$label ??= "";
$name ??= "";
$type ??= "text";
$value ??= "";
$multiple ??= false;
?>

<div class="form-group">
    <label for="<?= $name ?>"> <?= $label ?> </label>

    <?php if ($type === "textarea"): ?>
        <!-- Si le type est "textarea", affiche une zone de texte -->
        <textarea class="form-control" id="<?= $name ?>" name="<?= $name ?>"><?= $value ?></textarea>

    <?php else: ?>
        <!-- Sinon, affiche un champ de saisie en fonction du type défini -->
        <input
            <?= $multiple ? "multiple" : "" ?>  <!-- Ajoute l'attribut multiple si $multiple est true -->
            value="<?= $value ?>"              <!-- Valeur du champ de saisie -->
            class="form-control"               <!-- Classe CSS Bootstrap pour le style du champ -->
            id="<?= $name ?>"                   <!-- ID du champ de saisie -->
            type="<?= $type ?>"                 <!-- Type de champ de saisie (text, password, etc.) -->
            required                           <!-- Champ obligatoire -->
            name="<?= $name ?>"                 <!-- Nom du champ -->
        >
    <?php endif; ?>
</div>

