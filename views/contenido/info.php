<?php
use cesar\ProyectoTest\Config\Parameters;

$contenido = $data["informacion"]??NULL;
$slug = $data["slug"]??NULL;
$youtubeTrailer = $data["youtubeTrailer"]??NULL;
$tipo = $data["tipo"]??NULL;
$contenidoInfo = $data["contenidoInfo"]??NULL;
$genero = $data["genero"]??NULL;
$director = $data["director"]??NULL;
$idioma = $data["idioma"]??NULL;

$temporadaActual = 1 ?? NULL;
$capituloActual = 1 ?? NULL;

$temporadas = $data['temporadas'] ?? NULL;
$capitulosPorTemporada = $data['capitulosPorTemporada'] ?? NULL;


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
                <p><strong>Año:</strong> <?= $contenidoInfo->year ?></p>
                <?php if($tipo == '-') { ?>
                    <p><strong>Sinopsis:</strong> <?= $tipo ?></p>
                <?php }else{ ?>
                    <p><strong>Sinopsis:</strong> <?= $tipo->sinopsis ?></p>
                <?php } ?>
                <p><strong>Género:</strong> <?= $genero->nombre ?></p>
                <?php if ($contenidoInfo->tipo_contenido == 'series') { ?>
                    <p><strong>Temporadas:</strong> <?= $tipo->temporadas?></p>
                    <p><strong>Capítulos:</strong> <?= $tipo->capitulos?></p>
                <?php }else{ ?>
                    <p><strong>Duración:</strong> <?= $tipo->duracion . ' minutos' ?></p>
                <?php } ?>
                <p><strong>Director:</strong> <?= $director->nombre . ' ' . $director->apellidos ?></p>
                <?php if ($contenidoInfo->tipo_contenido == 'peliculas' || $contenidoInfo->tipo_contenido == 'series') { ?>
                    <p><strong>Reparto:</strong> <?= $contenido['Actors'] . '...' ?></p>
                    <p><strong>Idioma:</strong> <?= $idioma->nombre . ' ' ?><span class="fi fi-es"></span></p>
                    <p class="puntuacion-Imdb">
                        <strong>Puntuación:</strong> 
                        <span>
                            <?= $contenido['imdbRating'] ?>/10
                        </span>
                        <span class="material-symbols-outlined estrellas">star</span>
                    </p>
                    <div class="trailer">
                        <strong>Trailer:</strong>
                        <div class="video-responsive">
                            <div class="iframe-trailer-container">
                                <iframe src="<?=$youtubeTrailer?>" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($contenidoInfo->tipo_contenido == 'series') { ?>
                    <div class="temporadas-container">
                        <div class="temporadas">
                            <?php foreach ($temporadas as $temporada): ?>
                                <button data-temporada="<?php echo $temporada; ?>">Temporada <?php echo $temporada; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <div class="capitulos-container">
                            <?php foreach ($temporadas as $temporada): ?>
                                <ul class="capitulos" id="capitulos-temporada-<?php echo $temporada; ?>">
                                    <?php foreach ($capitulosPorTemporada[$temporada] as $capitulo): ?>
                                        <li>
                                            <a href="<?= Parameters::$BASE_URL . "verSerie/" . $slug . "/" . $temporada . "/" . $capitulo->num_capitulo ?>">
                                                Capítulo <?php echo $capitulo->num_capitulo; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php } ?>
                <p>
                <?php if ($contenidoInfo->tipo_contenido == 'series') { ?>
                    <a href="<?=Parameters::$BASE_URL . "verSerie/" . $slug . "/" . $temporadaActual . "/" . $capituloActual?>">
                    <?php }else{ ?>
                        <a href="<?=Parameters::$BASE_URL . "ver/" . $slug?>">
                    <?php } ?>
                        <?php if ($contenidoInfo->tipo_contenido == 'peliculas') { ?>
                            <button>Ver Pelicula</button>
                        <?php } if ($contenidoInfo->tipo_contenido == 'series') { ?>
                            <button>Ver Serie (Cap 1)</button>
                        <?php } if ($contenidoInfo->tipo_contenido == 'documentales') { ?>
                            <button>Ver Documental</button>
                        <?php } if ($contenidoInfo->tipo_contenido == 'cortos') { ?>
                            <button>Ver Corto</button>
                        <?php } ?>
                    </a>
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