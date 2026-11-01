<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CarMeet – Domov</title>
  <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
</head>
<body>

  <header>
    <div class="logo">CarMeet</div>
    <input type="search" placeholder="Hľadať...">
    <a href="#">Profil</a>
  </header>

  <div class="layout">
    <nav>
      <a href="<?= $link->url('home.index.html') ?>">Domov / Novinky</a>
      <a href="#">Podujatia</a>
      <a href="<?= $link->url('home.garage.html') ?>">Garáž</a>
      <a href="#">Kluby</a>
      <a href="#">Nastavenia</a>
    </nav>
    <main>
        <?= $contentHTML ?>
    </main>
  </div>

  <footer>
    <p>&copy; 2026 CarMeet</p>
  </footer>

</body>
</html>
