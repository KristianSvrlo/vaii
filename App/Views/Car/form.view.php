<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Car $car */
/** @var array $input */
/** @var string|null $error */

$isEdit = $car->id !== null;
$val = fn(string $key) => e($input[$key] ?? '');
?>

<div class="page-head">
    <h1><?= $isEdit ? 'Upraviť auto' : 'Pridať nové auto' ?></h1>
</div>

<?php if ($error): ?>
    <p class="form-error"><?= e($error) ?></p>
<?php endif; ?>

<form class="car-form" method="post" action="<?= $link->url('car.save') ?>">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= e($car->id) ?>">
    <?php endif; ?>

    <label for="brand">Značka</label>
    <input type="text" id="brand" name="brand" maxlength="50" required value="<?= $val('brand') ?>">

    <label for="model">Model</label>
    <input type="text" id="model" name="model" maxlength="50" required value="<?= $val('model') ?>">

    <label for="year">Rok výroby</label>
    <input type="number" id="year" name="year" min="1900" max="2100" required value="<?= $val('year') ?>">

    <label for="engine">Motor</label>
    <input type="text" id="engine" name="engine" maxlength="50" value="<?= $val('engine') ?>">

    <label for="powerKw">Výkon (kW)</label>
    <input type="number" id="powerKw" name="powerKw" min="1" max="5000" required value="<?= $val('powerKw') ?>">

    <label for="description">Popis</label>
    <textarea id="description" name="description" rows="4"><?= $val('description') ?></textarea>

    <div class="car-buttons">
        <button class="button" type="submit"><?= $isEdit ? 'Uložiť zmeny' : 'Pridať auto' ?></button>
        <a class="button" href="<?= $link->url('car.index') ?>">Zrušiť</a>
    </div>
</form>
