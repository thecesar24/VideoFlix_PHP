<?php
use cesar\ProyectoTest\Config\Parameters;

$contenidos = $data["contenidos"]??NULL;
$slug = $data["slug"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$tipos = $data["tipos"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$informacion = $data["informacion"]??NULL;

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
                </form>
                <?php if ($informacion) { ?>
                    <form action="<?=Parameters::$BASE_URL . "Contenido/addContenidoSave"?>" method="post">
                        <p>
                            <label for="">Titulo:</label>
                            <input type="text" name="titulo" id="" value="<?=$informacion['Title']?>" readonly/>
                        </p>
                        <p>
                            <label for="">Tipo:</label>
                            <select name="tipo_contenido">
                                <option value="" disabled selected>tipo del contenido</option>
                                <?php foreach($tipos as $tipo) { ?>
                                    <option value="<?=$tipo->tipo_contenido?>"><?=$tipo->tipo_contenido?></option>
                                <?php } ?>
                            </select>
                        </p>
                        <p>
                            <label for="">Año:</label>
                            <input type="text" name="año" id="año_nuevoContenido" value="<?=$informacion['Released']?>" readonly/>
                        </p>
                        <p>
                            <label for="">Sinopsis:</label>
                            <input type="text" name="sinopsis" id="" value="<?=$traduccion ?>"/>
                        </p>
                        <p>
                            <label for="">Géneros:</label>
                            <input type="text" name="generos" id="" value="<?=$informacion['Genre'] ?>" readonly/>
                        </p>
                        <p>
                            <label for="">Duración:</label>
                            <input type="number" name="duracion" id="" value="<?=$informacion['Runtime'] ?>"/>
                        </p>
                        <p>
                            <label for="">Director:</label>
                            <input type="text" name="director" id="" value="<?=$informacion['Director'] ?>"/>
                        </p>
                        <p class="puntuacion-Imdb">
                            <label for="">Puntuación:</label>
                            <input type="text" name="puntuacion" id="" value="<?=$informacion['imdbRating']?>" readonly/>
                            <span class="">/10</span>
                            <span class="material-symbols-outlined estrellas">star</span>
                        </p>
                        <p>
                            <input type="submit" value="Añadir">
                        </p>
                    </form>
                <?php } else { ?>
                    <form action="<?=Parameters::$BASE_URL . "Contenido/addContenidoSave"?>" method="post">
                        <p>
                            <label for="">Titulo:</label>
                            <input type="text" name="titulo" id="" value=""/>
                        </p>
                        <p>
                            <label for="">Tipo:</label>
                            <select name="tipo_contenido">
                                <option value="" disabled selected>tipo del contenido</option>
                                <?php foreach($tipos as $tipo) { ?>
                                    <option value="<?=$tipo->tipo_contenido?>"><?=$tipo->tipo_contenido?></option>
                                <?php } ?>
                            </select>
                        </p>
                        <p>
                            <label for="">Año:</label>
                            <input type="number" name="año" id="año_nuevoContenido" value=""/>
                        </p>
                        <p>
                            <label for="">Sinopsis:</label>
                            <input type="text" name="sinopsis" id="" value=""/>
                        </p>
                        <p>
                            <label for="">Géneros:</label>
                            <input type="text" name="generos" id="" value=""/>
                        </p>
                        <p>
                            <label for="">Duración:</label>
                            <input type="number" name="duracion" id="" value=""/>
                        </p>
                        <p>
                            <label for="">Director:</label>
                            <input type="text" name="director" id="" value=""/>
                        </p>
                        <p class="puntuacion-Imdb">
                            <label for="">Puntuación:</label>
                            <input type="number" name="director" id="" value=""/>
                            <span class="">/10</span>
                            <span class="material-symbols-outlined estrellas">star</span>
                        </p>
                        <p>
                            <input type="submit" value="Añadir">
                        </p>
                    </form>
                <?php } ?>
            </article>
            <article class="flex-2-info">
                <?php if (isset($informacion['Poster'])) { ?>
                    <img src="<?= $informacion['Poster'] ?>" alt="Poster" />
                <?php } else { ?>
                    <span></span>
                <?php } ?>
            </article>
        <?php }else{ ?>
            <p>No se encontró información para esta película o serie.</p>
        <?php } ?>
    </section>
</div>