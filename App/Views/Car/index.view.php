<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Car[] $cars */

$count = count($cars);
$word = match (true) {
    $count === 1 => 'auto',
    $count >= 2 && $count <= 4 => 'autá',
    default => 'áut',
};
?>

<div class="page-head">
    <h1>Moja garáž (<?= $count ?> <?= $word ?>)</h1>
    <a class="button" href="<?= $link->url('car.create') ?>">+ Pridať nové auto</a>
</div>

<?php if ($count === 0): ?>
    <p>Garáž je zatiaľ prázdna.</p>
<?php endif; ?>

<div class="cars">
    <?php foreach ($cars as $car): ?>
        <article class="car">
            <div class="car-top">
                <div class="photo">Fotografia</div>
                <div>
                    <h2><?= e($car->brand) ?> <?= e($car->model) ?></h2>
                    <p>Rok: <?= e($car->year) ?></p>
                    <?php if ($car->engine): ?>
                        <p>Motor: <?= e($car->engine) ?></p>
                    <?php endif; ?>
                    <p>Výkon: <?= e($car->powerKw) ?> kW</p>
                    <?php if ($car->description): ?>
                        <p><b>Popis</b><br><?= nl2br(e($car->description)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="car-buttons">
                <a class="button" href="<?= $link->url('car.edit', ['id' => $car->id]) ?>">Upraviť</a>
                <form method="post" action="<?= $link->url('car.delete') ?>"
                      onsubmit="return confirm('Naozaj zmazať toto auto?');">
                    <input type="hidden" name="id" value="<?= e($car->id) ?>">
                    <button class="button" type="submit">Zmazať</button>
                </form>
            </div>
        </article>
    <?php endforeach; ?>
    <a class="empty-slot" href="<?= $link->url('car.create') ?>">Voľné miesto – pridať auto</a>
</div>
