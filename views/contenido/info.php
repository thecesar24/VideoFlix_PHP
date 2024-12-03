<?php
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

$contenido = $data["informacion"]??NULL;
$slug = $data["slug"]??NULL;

var_dump($contenido);

if (isset($_SESSION['errores'])) {
    foreach ($_SESSION['errores'] as $error) {
        echo "<p class='error'>$error</p>"; // Muestra cada mensaje de error
    }
    unset($_SESSION['errores']); // Limpiar los errores después de mostrarlos
}


if (isset($_SESSION['mensaje'])) {
    echo "<div id='mensaje-temporal' >{$_SESSION['mensaje']}</div>";
    unset($_SESSION['mensaje']);
}


?>

<div class="container container-verInfo">
    <section class="verInfo-section">
        <?php if ($contenido){ ?>
            <article class="flex-1">
                <h1><?= $contenido['Title'] ?></h1>
                <p><strong>Año:</strong> <?= $contenido['Released'] ?></p>
                <p><strong>Sinopsis:</strong> <?= $contenido['Plot'] ?></p>
                <p><strong>Géneros:</strong> <?= $contenido['Genre'] ?></p>
                <p><strong>Duración:</strong> <?= $contenido['Runtime'] ?></p>
                <p><strong>Director:</strong> <?= $contenido['Director'] ?></p>
                <p><strong>Puntuación:</strong> <?= $contenido['imdbRating'] ?>/10</p>

                <a href="<?=Parameters::$BASE_URL . "ver/$slug"?>">
                    <button>Ver</button>
                </a>
            </article>
            <article class="flex-2">
                <img src="<?= $contenido['Poster'] ?>" alt="Poster" />
            </article>
        <?php }else{ ?>
            <p>No se encontró información para esta película o serie.</p>
        <?php } ?>
    </section>
</div>