<?php
use cesar\ProyectoTest\Config\Parameters;

$contenidos = $data["contenidos"]??NULL;
$slug = $data["slug"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$tipos = $data["tipos"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$informacion = $data["informacion"]??NULL;
$directores = $data["directores"]??NULL;
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

<div class="container container-verInfo">
    <section class="verInfo-section">
        <?php if ($contenidos){ ?>
            <article class="flex-1-info">
                <h2>Añadir Nuevo Contenido:</h2>
                <form action="<?=Parameters::$BASE_URL . "Contenido/buscarNuevoContenido"?>" method="post">
                    <label for="">Buscar Contenido:</label>
                    <input type="text" name="titulo" placeholder="titulo del contenido">
                    <input type="submit" value="Buscar nuevo contenido">
                    <input type="submit" id="reset-Button" name='btnReset' value="Reiniciar contenido">
                </form>
                <?php if ($informacion) { ?>
                    <form id="formulario_nuevo_contenido" action="<?=Parameters::$BASE_URL . "Contenido/addContenidoSave"?>" method="post">
                        <p>
                            <label for="">Titulo:</label>
                            <input type="text" name="titulo" id="titulo" value="<?=$informacion['Title']?>" readonly/>
                        </p>
                        <p>
                            <label for="tipo_contenido">Tipo:</label>
                            <select name="tipo_contenido" id="tipo_contenido">
                                <option value="" disabled selected>Selecciona el tipo de contenido</option>
                                <option value="cortos">Cortos</option>
                                <option value="series">Series</option>
                                <option value="peliculas">Películas</option>
                                <option value="documentales">Documentales</option>
                            </select>
                        </p>
                        <p>
                            <label for="">Año:</label>
                            <input type="text" name="year" id="año_nuevoContenido" value="<?=$informacion['Released']?>" readonly></input>
                        </p>
                        <p>
                            <label for="">Sinopsis:</label>
                            <input type="text" name="sinopsis" id="sinopsis" value="<?=$traduccion ?>"/>
                        </p>
                        <p>
                            <label for="">Géneros:</label>
                            <input type="text" name="generos" id="generos" value="<?=$informacion['Genre'] ?>" readonly/>
                        </p>
                        <p id="duracion-container">
                            <label for="">Duración:</label>
                            <input type="number" name="duracion" id="duracion" value="" placeholder="Duración en minutos"/>
                        </p>
                        <p id="temporadas-container" style="display: none;">
                            <label for="temporadas">Temporadas:</label>
                            <input type="number" name="temporadas" id="temporadas" value="<?=$informacion['totalSeasons']?>" placeholder="Número de temporadas" />
                        </p>
                        <p id="capitulos-container" style="display: none;">
                            <label for="capitulos">Capítulos:</label>
                            <input type="number" name="capitulos" id="capitulos" value="" placeholder="Número de capítulos" />
                        </p>
                        <p>
                            <label for="">Director:</label>
                            <input type="text" name="nuevo_director" id="nuevo_director" value="<?=$informacion['Director'] ?>"/>
                        </p>
                        <p class="puntuacion-Imdb">
                            <label for="">Puntuación:</label>
                            <input type="text" name="puntuacion" id="puntuacion" value="<?=$informacion['imdbRating']?>" readonly/>
                            <span class="">/10</span>
                            <span class="material-symbols-outlined estrellas">star</span>
                        </p>
                        <p>
                            <label for="">Url:</label>
                            <input type="text" name="url" id="url" value="<?=$youtubeUrl ?>" readonly/>
                        </p>
                        <p>
                            <input type="submit" value="Añadir">
                        </p>
                    </form>
                <?php } else { ?>
                    <form id="formulario_nuevo_contenido" action="<?=Parameters::$BASE_URL . "Contenido/addContenidoSave"?>" method="post">
                        <p>
                            <label for="">Titulo:</label>
                            <input type="text" name="titulo" id="" value=""/>
                        </p>
                        <p>
                            <label for="tipo_contenido">Tipo:</label>
                            <select name="tipo_contenido" id="tipo_contenido">
                                <option value="" disabled selected>Selecciona el tipo de contenido</option>
                                <option value="cortos">Cortos</option>
                                <option value="series">Series</option>
                                <option value="peliculas">Películas</option>
                                <option value="documentales">Documentales</option>
                            </select>
                        </p>
                        <p>
                            <label for="">Año:</label>
                            <input type="number" name="year" id="año_nuevoContenido" value=""/>
                        </p>
                        <p>
                            <label for="">Sinopsis:</label>
                            <input type="text" name="sinopsis" id="" value=""/>
                        </p>
                        <p>
                            <label for="">Géneros:</label>
                            <input type="text" name="generos" id="" value=""/>
                        </p>
                        <p id="duracion-container">
                            <label for="">Duración:</label>
                            <input type="number" name="duracion" id="duracion" value="" placeholder="Duración en minutos"/>
                        </p>
                        <p id="temporadas-container" style="display: none;">
                            <label for="temporadas">Temporadas:</label>
                            <input type="number" name="temporadas" id="temporadas" value="" placeholder="Número de temporadas" />
                        </p>
                        <p id="capitulos-container" style="display: none;">
                            <label for="capitulos">Capítulos:</label>
                            <input type="number" name="capitulos" id="capitulos" value="" placeholder="Número de capítulos" />
                        </p>
                        <p>
                            <label for="director_existente">Seleccionar Director:</label>
                            <select id="director_existente" name="director_existente">
                                <option value="" selected disabled>-- Seleccione un Director --</option>
                                <?php foreach ($directores as $director){ ?>
                                    <option value="<?= $director['id'] ?>">
                                        <?= $director['nombre'] . ' ' . $director['apellidos'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                                <label for="nuevo_director">O añadir un nuevo director:</label>
                                <input type="text" id="nuevo_director" name="nuevo_director" placeholder="Nombre Apellidos">
                        </p>
                        <p class="puntuacion-Imdb">
                            <label for="">Puntuación:</label>
                            <input type="number" name="puntuacion" id="" value=""/>
                            <span class="">/10</span>
                            <span class="material-symbols-outlined estrellas">star</span>
                        </p>
                        <p>
                            <label for="">Url:</label>
                            <input type="text" name="url" id="url" value=""/>
                        </p>
                        <p>
                            <input type="submit" value="Añadir">
                        </p>
                    </form>
                <?php } ?>
            </article>
            <article class="flex-2-info">
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