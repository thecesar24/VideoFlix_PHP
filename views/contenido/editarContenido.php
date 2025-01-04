<?php
use cesar\ProyectoTest\Config\Parameters;

$contenido = $data["contenido"]??NULL;
$slug = $data["slug"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$tipos = $data["tipos"]??NULL;
$traduccion = $data["traduccion"]??NULL;
$informacion = $data["informacion"]??NULL;
$directores = $data["directores"]??NULL;
$youtubeUrl = $data["youtubeUrl"]??NULL;
$generos = $data["generos"]??NULL;
$tipo_contenido = $data["tipo_contenido"]??NULL;

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

if (is_null($contenido->portada)) {
    $contenido->portada = 'Default_Portada.png';
}

?>

<div class="container container-verInfo">
    <section class="editar-contenido">
        <?php if ($contenido){ ?>
            <article class="editar-contenido-article">
                <h2>Editar Contenido:</h2>
                    <form id="formulario_editar_contenido" class="formulario-editar-contenido" action="<?=Parameters::$BASE_URL . "Contenido/editarContenidoSave?idContenido=" . $contenido->id?>" method="post" enctype="multipart/form-data">
                        <p>
                            <label for="titulo">Titulo:</label>
                            <input type="text" name="titulo" id="titulo" value="<?=$contenido->titulo ?>"/>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['titulo'])) {
                                    echo $_SESSION['errores-span']['titulo'];
                                } ?>
                            </span>
                        </p>
                        <p>
                            <label for="año">Año:</label>
                            <input type="number" name="año" id="año" value="<?=$contenido->year ?>"/>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['year'])) {
                                    echo $_SESSION['errores-span']['year'];
                                } ?>
                            </span>
                        </p>
                        <?php if ($contenido->tipo_contenido != 'documentales') { ?>
                        <p>
                            <label for="sinopsis">Sinopsis:</label>
                            <textarea maxlength="400" name="sinopsis" id="sinopsis" value="<?=$tipo_contenido->sinopsis ?>"><?=$tipo_contenido->sinopsis ?></textarea>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['sinopsis'])) {
                                    echo $_SESSION['errores-span']['sinopsis'];
                                } ?>
                            </span>
                        </p>
                        <?php } ?>
                        <p>
                            <label for="genero">Géneros:</label>
                            <select name="genero" id="genero">
                                <option value="" disabled selected>Selecciona el genero</option>
                                <?php foreach ($generos as $genero) { ?>
                                    <?php if ($contenido->tipo_contenido == 'documentales') { ?>
                                        <?php if ($genero['id'] == $contenido->id_genero) { ?>
                                            <option value="<?=$genero['id'] ?>" selected disabled><?=$genero['nombre']?></option>
                                        <?php } ?>    
                                    <?php } else { ?>
                                        <?php if ($genero['id'] == $contenido->id_genero) { ?>
                                            <option value="<?=$genero['id'] ?>" selected><?=$genero['nombre']?></option>
                                        <?php } else { ?>
                                            <option value="<?=$genero['id'] ?>"><?=$genero['nombre']?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['genero'])) {
                                    echo $_SESSION['errores-span']['genero'];
                                } ?>
                            </span>
                        </p>
                        <?php if($contenido->tipo_contenido == 'peliculas' || $contenido->tipo_contenido == 'cortos' || $contenido->tipo_contenido == 'documentales') { ?>
                        <p id="duracion-container">
                            <label for="">Duración:</label>
                            <input type="number" name="duracion" id="duracion" value="<?=$tipo_contenido->duracion?>" placeholder="Duración en minutos"/><span>mins</span>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['duracion'])) {
                                    echo $_SESSION['errores-span']['duracion'];
                                } ?>
                            </span>
                        </p>
                        <?php } else { ?>
                        <p id="temporadas-container">
                            <label for="temporadas">Temporadas:</label>
                            <input type="number" name="temporadas" id="temporadas" value="<?=$tipo_contenido->temporadas?>" placeholder="Número de temporadas" />
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['temporadas'])) {
                                    echo $_SESSION['errores-span']['temporadas'];
                                } ?>
                            </span>
                        </p>
                        <p id="capitulos-container">
                            <label for="capitulos">Capítulos:</label>
                            <input type="number" name="capitulos" id="capitulos" value="<?=$tipo_contenido->capitulos?>" placeholder="Número de capítulos" />
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['capitulos'])) {
                                    echo $_SESSION['errores-span']['capitulos'];
                                } ?>
                            </span>
                        </p>
                        <?php } ?>
                        <p>
                            <label for="director">Director:</label>
                            <select name="director" id="director">
                                <option value="" disabled selected>Selecciona el director</option>
                            <?php foreach ($directores as $director) { ?>
                                <?php if ($director['id'] == $contenido->id_director    ) { ?>
                                    <option value="<?=$director['id'] ?>" selected><?=$director['nombre'] . ' ' . $director['apellidos']?></option>
                                <?php }else{ ?>
                                    <option value="<?=$director['id'] ?>"><?=$director['nombre'] . ' ' . $director['apellidos']?></option>
                                <?php } ?>
                            <?php } ?>
                            </select>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['director'])) {
                                    echo $_SESSION['errores-span']['director'];
                                } ?>
                            </span>
                        </p>
                        <div class="puntuacion-Imdb-edit">
                            <label for="puntuacion">Puntuación:</label>
                            <div>
                                <input type="decimal" name="puntuacion" id="puntuacion" value="<?=$tipo_contenido->puntuacion?>"/>
                                <span class="">/10</span>
                                <span class="material-symbols-outlined estrellas">star</span>
                            </div>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['puntuacion'])) {
                                    echo $_SESSION['errores-span']['puntuacion'];
                                } ?>
                            </span>
                        </div>
                        <p>
                            <label for="">Url:</label>
                            <input type="text" name="url" id="url" value="<?=$contenido->video ?>"/>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['url'])) {
                                    echo $_SESSION['errores-span']['url'];
                                } ?>
                            </span>
                        </p>
                        <div>
                            <label for="portada">Portada:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text">Subir</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="portada" accept=".jpg,.png,.jpeg" class="custom-file-input" id="inputGroupFile01"/>
                                    <label class="custom-file-label" for="inputGroupFile01">Elegir archivo</label>
                                </div>
                            </div>
                            <span class="error-span">
                                <?php if(isset($_SESSION['errores-span']) && isset($_SESSION['errores-span']['portada'])) {
                                    echo $_SESSION['errores-span']['portada'];
                                } ?>
                            </span>
                            <img id="imagePreview" src="<?=Parameters::$BASE_URL . 'assets/img/Portadas/' . $contenido->portada?>" alt="Vista previa" />
                        </div>    
                        <p>
                            <input class="editar-confirmar" type="submit" value="Confirmar">
                        </p>
                    </form>
            </article>
        <?php }else{ ?>
            <p>No se encontró información para esta película o serie.</p>
        <?php } unset($_SESSION['errores-span']) ?>
    </section>
</div>