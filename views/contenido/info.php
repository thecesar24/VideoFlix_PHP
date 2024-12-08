<?php
use cesar\ProyectoTest\Config\Parameters;

$contenido = $data["informacion"]??NULL;
$slug = $data["slug"]??NULL;
$youtubeTrailer = $data["youtubeTrailer"]??NULL;
$traduccion = $data["traduccion"]??NULL;

//var_dump($youtubeTrailer);

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
            <article class="flex-1-info">
                <h1><?= $contenido['Title'] ?></h1>
                <p><strong>Año:</strong> <?= $contenido['Released'] ?></p>
                <p><strong>Sinopsis:</strong> <?= $traduccion ?></p>
                <p><strong>Géneros:</strong> <?= $contenido['Genre'] ?></p>
                <p><strong>Duración:</strong> <?= $contenido['Runtime'] ?></p>
                <p><strong>Director:</strong> <?= $contenido['Director'] ?></p>
                <p class="puntuacion-Imdb">
                    <strong>Puntuación:</strong> 
                    <span>
                        <?= $contenido['imdbRating'] ?>/10
                    </span>
                    <span class="material-symbols-outlined estrellas">star</span>
                </p>

                <a href="<?=Parameters::$BASE_URL . "ver/" . $slug?>">
                    <button>Ver</button>
                </a>
                <p>
                    <span>Trailer:</span>
                    <iframe src="<?=$youtubeTrailer?>" frameborder="0"></iframe>
                </p>
            </article>
            <article class="flex-2-info">
                <img src="<?= $contenido['Poster'] ?>" alt="Poster" />
            </article>
        <?php }else{ ?>
            <p>No se encontró información para esta película o serie.</p>
        <?php } ?>
    </section>
</div>