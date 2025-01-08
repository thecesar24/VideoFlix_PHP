<?php
use cesar\ProyectoTest\Config\Parameters;

$contenidos = $data["contenidos"]??NULL;
$slug = $data["slug"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$tipos = $data["tipos"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$informacion = $data["informacion"]??NULL;
$directores = $data["directores"]??NULL;
$generos = $data["generos"]??NULL;
$generoTraducido = $data["generoTraducido"]??NULL;
$youtubeUrl = $data["youtubeUrl"]??NULL;

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

<div class="anadir-container">
    <section class="anadir-section">
        <?php if ($contenidos){ ?>
            <article class="flex-1-anadir">
                <h2>Añadir Nuevo Contenido:</h2>
                <form action="<?=Parameters::$BASE_URL . "Contenido/buscarNuevoContenido"?>" method="post">
                    <label for="">Buscar Contenido:</label>
                    <input type="text" name="titulo" placeholder="Título del contenido" class="anadir-input">
                    <input type="submit" value="Buscar nuevo contenido" class="anadir-input">
                    <input type="submit" id="reset-Button" name='btnReset' value="Reiniciar contenido" class="anadir-input">
                </form>
                <?php if ($informacion) { ?>
                    <form id="formulario_nuevo_contenido" action="<?=Parameters::$BASE_URL . "Contenido/addContenidoSave"?>" method="post" enctype="multipart/form-data" class="anadir-form">
                        <p>
                            <label for="">Título:</label>
                            <input type="text" name="titulo" id="titulo" value="<?=$informacion['Title']?>" readonly class="anadir-input"/>
                        </p>
                        <p>
                            <label for="tipo_contenido">Tipo:</label>
                            <select name="tipo_contenido" id="tipo_contenido" class="anadir-select">
                                <option value="" disabled selected>Selecciona el tipo de contenido</option>
                                <option value="cortos">Cortos</option>
                                <option value="series">Series</option>
                                <option value="peliculas">Películas</option>
                                <option value="documentales">Documentales</option>
                            </select>
                        </p>
                        <p>
                            <label for="">Año:</label>
                            <input type="text" name="year" id="año_nuevoContenido" value="<?=$informacion['Released']?>" readonly class="anadir-input"/>
                        </p>
                        <p id="sinopsis-container">
                            <label for="">Sinopsis:</label>
                            <input type="text" name="sinopsis" id="sinopsis" value="<?=$traduccion ?>" class="anadir-input"/>
                        </p>
                        <p>
                            <label for="nuevo_genero">Géneros:</label>
                            <input type="text" name="nuevo_genero" id="nuevo_genero" value="<?=$generoTraducido ?>" readonly class="anadir-input"/>
                        </p>
                        <p id="duracion-container">
                            <label for="">Duración:</label>
                            <input type="number" name="duracion" id="duracion" value="" placeholder="Duración en minutos" class="anadir-input"/>
                        </p>
                        <p id="temporadas-container" style="display: none;">
                            <label for="temporadas">Temporadas:</label>
                            <input type="number" name="temporadas" id="temporadas" value="<?= $informacion['totalSeasons']??'0'?>" placeholder="Número de temporadas" class="anadir-input"/>
                        </p>
                        <p id="capitulos-container" style="display: none;">
                            <label for="capitulos">Capítulos:</label>
                            <input type="number" name="capitulos" id="capitulos" value="" placeholder="Número de capítulos" class="anadir-input"/>
                        </p>
                        <p>
                            <label for="">Director:</label>
                            <input type="text" name="nuevo_director" id="nuevo_director" value="<?=$informacion['Director'] ?>" class="anadir-input"/>
                        </p>
                        <p class="puntuacion-Imdb" id="puntuacion-container">
                            <label for="">Puntuación:</label>
                            <input type="text" name="puntuacion" id="puntuacion" value="<?=$informacion['imdbRating']?>" readonly class="anadir-input"/>
                            <span class="">/10</span>
                            <span class="material-symbols-outlined estrellas">star</span>
                        </p>
                        <p>
                            <label for="">Url:</label>
                            <input type="text" name="url" id="url" value="<?=$youtubeUrl ?>" readonly class="anadir-input"/>
                        </p>
                        <p>
                            <label for="poster">Poster (URL de OMDB):</label>
                            <input type="text" name="poster_url" id="poster_url" value="<?= $informacion['Poster'] ?? '' ?>" readonly class="anadir-input">
                        </p>
                        <p>
                            <input type="submit" value="Añadir" class="anadir-input">
                        </p>
                    </form>
                <?php } else { ?>
                    <form id="formulario_nuevo_contenido" action="<?=Parameters::$BASE_URL . "Contenido/addContenidoSave"?>" method="post" enctype="multipart/form-data" class="anadir-form">
                        <p>
                            <label for="">Título:</label>
                            <input type="text" name="titulo" id="" value="" class="anadir-input" placeholder="Añadir un titulo"/>
                        </p>
                        <p>
                            <label for="tipo_contenido">Tipo:</label>
                            <select name="tipo_contenido" id="tipo_contenido" class="anadir-select">
                                <option value="" disabled selected>Selecciona el tipo de contenido</option>
                                <option value="cortos">Cortos</option>
                                <option value="series">Series</option>
                                <option value="peliculas">Películas</option>
                                <option value="documentales">Documentales</option>
                            </select>
                        </p>
                        <p>
                            <label for="">Año:</label>
                            <input type="number" name="year" id="año_nuevoContenido" value="" class="anadir-input" placeholder="Añadir el año del contenido"/>
                        </p>
                        <p id="sinopsis-container">
                            <label for="sinopsis">Sinopsis:</label>
                            <input type="text" name="sinopsis" id="sinopsis" value="" class="anadir-input"/>
                        </p>
                        <div id="aniadir-genero">
                            <div id="generos-container">
                                <label for="genero_existente">Seleccionar Género:</label>
                                <select id="genero_existente" name="genero_existente" class="anadir-select">
                                    <option value="" selected disabled>-- Seleccione un Género --</option>
                                    <?php foreach ($generos as $genero) { ?>
                                        <option value="<?= $genero['id'] ?>">
                                            <?= $genero['nombre'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div id="generos-nuevos-container">
                                <label for="nuevo_genero">O añadir un nuevo género:</label>
                                <input type="text" id="nuevo_genero" name="nuevo_genero" placeholder="Nuevo Género" class="anadir-input">
                            </div>
                        </div>
                        <p id="duracion-container">
                            <label for="duracion">Duración:</label>
                            <input type="number" name="duracion" id="duracion" value="" placeholder="Duración en minutos" class="anadir-input"/>
                        </p>
                        <p id="temporadas-container" style="display: none;">
                            <label for="temporadas">Temporadas:</label>
                            <input type="number" name="temporadas" id="temporadas" value="" placeholder="Número de temporadas" class="anadir-input"     />
                        </p>
                        <p id="capitulos-container" style="display: none;">
                            <label for="capitulos">Capítulos:</label>
                            <input type="number" name="capitulos" id="capitulos" value="" placeholder="Número de capítulos" class="anadir-input"/>
                        </p>
                        <div id="aniadir-director">
                            <div class="aniadir-nuevo-director">
                                <label for="director_existente">Seleccionar Director:</label>
                                <select id="director_existente" name="director_existente" class="anadir-select">
                                    <option value="" selected disabled>-- Seleccione un Director --</option>
                                    <?php foreach ($directores as $director){ ?>
                                        <option value="<?= $director['id'] ?>">
                                            <?= $director['nombre'] . ' ' . $director['apellidos'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="aniadir-nuevo-director">
                                <label for="nuevo_director">O añadir un nuevo director:</label>
                                <input type="text" id="nuevo_director" name="nuevo_director" placeholder="Nombre Apellidos" class="anadir-input">
                            </div>
                        </div>
                        <div class="puntuacion-Imdb-aniadir" id="puntuacion-container">
                            <label for="">Puntuación:</label>
                            <div class="puntuacion-Imdb">
                                <input type="number" name="puntuacion" id="" value="" class="anadir-input" placeholder="Añadir puntuacion (1-10)"/>
                                <span class="">/10</span>
                                <span class="material-symbols-outlined estrellas">star</span>
                            </div>
                        </div>
                        <p>
                            <label for="">Url:</label>
                            <input type="text" name="url" id="url" value="" class="anadir-input" placeholder="Añadir url youtube embed"/>
                        </p>
                        <p>
                            <label for="poster_file">Subir otro poster:</label>
                            <input type="file" name="poster_file" id="poster_file" accept="image/*" class="anadir-input">
                        </p>
                        <p>
                            <input type="submit" value="Añadir" class="anadir-input">
                        </p>
                    </form>
                <?php } ?>
            </article>
            <article class="flex-2-anadir">
                <?php if (isset($informacion['Poster'])) { ?>
                    <img src="<?= $informacion['Poster'] ?>" id="Poster" alt="Poster" />
                <?php } else { ?>
                    <span></span>
                <?php } ?>
            </article>
        <?php }else{ ?>
            <p>No se encontró información para esta película o serie.</p>
        <?php } ?>
    </section>
</div>