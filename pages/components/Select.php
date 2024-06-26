<?php
// Initialisation des variables avec des valeurs par défaut si elles ne sont pas déjà définies
$label ??= "";
$name ??= "";
$value ??= "";
$multiple ??= false;
?>
<div class="form-group">

    <label for="<?= $name ?>" ><?= $label ?></label>
    <select class="form-control" name="<?= $name ?>" id="<?= $name ?>" <?= $multiple ? "multiple" : "" ?>>
        <?php foreach ($value as $v): ?>
            <option value="<?= $v["id"] ?>">
                <?= $v["name"] ?>
            </option>
        <?php endforeach; ?>
    </select>

</div>

